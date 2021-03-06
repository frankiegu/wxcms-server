<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appid')->default(0); //绑定管理员id
            $table->integer('genre')->comment('应用类型')->default(0);
            $table->string('app_name')->comment('应用名')->nullable();
            $table->string('app_id')->comment('AppID')->nullable();
            $table->string('app_secret')->comment('AppSecret')->nullable(); // 单机这样用还可以，做平台的话不够安全
            $table->string('refresh_token')->comment('授权方的refresh_token')->nullable(); // 通过第三方授权获取的权限(更安全)
            $table->string('current_version')->comment('体验版本')->nullable(); // 当前版本(体验版本)
            $table->string('release_version')->comment('发布版本')->nullable(); // 发布版本
            $table->boolean('allow_synchronized_version')->comment('允许系统同步版本')->default(0); //用户允许系统同步版时，管理员可以批量静默升级用户的代码到最新版本()
            $table->boolean('follow_status')->comment('公众号关注组件')->default(0);
            $table->string('reward_adid')->comment('激励式视频id')->nullable();
            $table->string('banner_adid')->comment('banner广告id')->nullable();
            $table->string('screen_adid')->comment('插屏广告id')->nullable();
            $table->string('template_topic')->comment('模板主题')->nullable(); // 红 蓝 绿 等不同主题
            $table->float('point_score_ratio')->comment('积分比值(小程序展示积分实值比)')->nullable();
            $table->string('point_score_type')->comment('积分类型(小程序展示积分标题)')->nullable();
            $table->string('default_search')->comment('默认搜索值')->nullable();
            $table->string('jump_adpage')->comment('分享图跳转广告页地址')->nullable();
            $table->string('jump_background')->comment('分享图跳转广告页背景')->nullable();
            $table->integer('index_share_id')->comment('首页分享策略')->default(0);
            $table->integer('topic_share_id')->comment('专题首页分享策略')->default(0);
            $table->integer('quota')->comment('周期额度量')->default(0);
            $table->integer('current_quota')->comment('当前周期使用额度')->default(0); // 注：这个参数在发工资时由剩余积分同步过来 (用于限制用户这个月新获取的积分不能在结算前使用)
            $table->integer('total_quota')->comment('总使用额度')->default(0);
            $table->integer('attach_quota')->comment('附加额度数')->default(0);
            $table->boolean('show_poster_btn')->comment('显示文章海报按钮')->default(1);
            $table->boolean('rank_status')->comment('开放排行榜')->default(0);
            $table->boolean('shopping_status')->comment('开放积分商城')->default(0);
            $table->boolean('point_logs_status')->comment('开放积分记录')->default(0);
            $table->boolean('reward_status')->comment('开放激励记录')->default(0);
            $table->boolean('point_enabled')->comment('积分系统是否启动?')->default(1);
            $table->boolean('point_day_sign_num')->comment('开启签到得积分功能')->default(1);
            $table->boolean('point_day_reward_num')->comment('开启激励得积分功能')->default(1);
            $table->integer('point_default_fromid')->comment('默认奖励pid')->default(0);
            $table->integer('point_sign_action')->comment('签到可以获得积分')->default(10);
            $table->integer('point_reward_action')->comment('激励可以获得积分')->default(10);
            $table->integer('point_read_action')->comment('阅读可以获得积分')->default(1);
            $table->integer('point_day_read_num')->comment('一天可以获得10次阅读积分')->default(10);
            $table->integer('point_like_action')->comment('点赞可以获得积分')->default(2);
            $table->integer('point_day_like_num')->comment('一天可以获得5次点赞积分')->default(5);
            $table->integer('point_reward_article_action')->comment('文章激励可以获得积分')->default(5);
            $table->integer('point_day_reward_article_num')->comment('一天可以获得5次文章激励积分')->default(5);
            $table->boolean('point_rereading_reward')->comment('重复阅读同一篇文章给予奖励')->default(0);
            $table->boolean('point_repeated_incentives')->comment('重复激励同一篇文章给予奖励')->default(0);
            $table->integer('point_author_article_reward_action')->comment('作者文章被激励(加分给作者次数不设上限)')->default(5);
            
            $table->boolean('point_channel_status')->comment('渠道功能开启')->default(0);
            $table->integer('point_interview_action')->comment('邀请新人访问可以获得积分')->default(10);
            $table->integer('point_day_interview_num')->comment('一天可以获得多少次邀请新人奖励')->default(100);
            $table->integer('point_share_action')->comment('分享访问获得多少积分')->default(1);
            $table->integer('point_day_share_num')->comment('一天可以获得多少次分享访问积分')->default(10);
            $table->integer('point_day_fansign_action')->comment('受邀用户签到')->default(2);
            $table->integer('point_day_fansign_num')->comment('一天可以获得300次邀请新人签到积分')->default(300);
            $table->boolean('point_day_team_double_enabled')->comment('组队双倍积分功能是否开启')->default(0);

            $table->integer('vip_status')->comment('vip状态')->default(0);
            $table->timestamp('vip_deadline',0)->comment('vip截止时间')->nullable();
            $table->boolean('secret_locking')->comment('锁定小程序密令不给更改')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps');
    }
}
