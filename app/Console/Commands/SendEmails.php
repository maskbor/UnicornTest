<?php

namespace App\Console\Commands;

use App\Action;
use App\Jobs\SendNotifyMailQueue;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send 
                { --action= : ID акции }
                { --groupAll : Разослать письма всем группам пользователей } 
                { --groupA : Разослать письма тем пользователям, у кого есть хотя бы одна авторизация } 
                { --groupB : Разослать письма тем пользователям, у кого больше двух авторизаций за прошедший месяц } 
                { --groupC : Разослать письма тем пользователям, у кого есть хотя бы одна авторизация за прошлый месяц и не было авторизации в период действия акции }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Маркетинговые рассылки пользователям';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $options = $this->options();
        if($options["groupAll"]){
            $this->sendGroupA();
            $this->sendGroupB();
            $this->sendGroupC($options["action"]);
        } elseif($options["groupA"]) {
            $this->sendGroupA();
        } elseif($options["groupB"]) {
            $this->sendGroupB();
        } elseif($options["groupC"]) {
            $this->sendGroupC($options["action"]);
        }
    }

    private function sendGroupA()
    {
        $usersIDs = DB::table('login_sources')
            ->pluck('user_id');

        $users = User::whereIn('id', $usersIDs)->get();

        foreach ($users as $user) {
            dispatch(new SendNotifyMailQueue('emails.groupA', $user));
        }
    }

    private function sendGroupB()
    {
        $usersIDs = DB::table('login_sources')
            ->select('user_id')
            ->whereBetween(
                'tms',
                [
                    Carbon::now()->subMonth()->startOfMonth()->toDateString(),
                    Carbon::now()->startOfMonth()->toDateString()
                ]
            )
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) >= 2')
            ->pluck('user_id');

        $users = User::whereIn('id', $usersIDs)->get();

        foreach ($users as $user) {
            dispatch(new SendNotifyMailQueue('emails.groupB', $user));
        }
    }

    private function sendGroupС($action=null)
    {
        $userActionIDs = DB::table('login_sources')
            ->rightJoin('user_actions', 'user_actions.user_id', '=', 'login_sources.user_id')
            ->join('actions', 'user_actions.action_id', '=', 'actions.id')
            ->whereBetween(
                'tms',
                [
                    Carbon::now()->subMonth()->startOfMonth()->toDateString(),
                    Carbon::now()->startOfMonth()->toDateString()
                ]
            )
            ->whereNotExists(function ($query) {
                $query->select(DB::raw('*'))
                      ->from('login_sources AS ls')
                      ->whereRaw('tms between actions.date_start AND actions.date_end')
                      ->whereColumn('login_sources.user_id', 'ls.user_id');
            })
            ->groupBy('login_sources.user_id', 'user_actions.action_id')
            ->havingRaw('COUNT(login_sources.id) >= 1')
            ->select('login_sources.user_id', 'user_actions.action_id');
            
        if($action) $userActionIDs = $userActionIDs->where('actions.id', '=', $action);
        $userActionIDs = $userActionIDs->get();

        foreach ($userActionIDs as $userActionID) {
            dispatch(new SendNotifyMailQueue(
                'emails.groupC', 
                User::find($userActionID->user_id),
                Action::find($userActionID->action_id)
            ));
        }
    }
}
