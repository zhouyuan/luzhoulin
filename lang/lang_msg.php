<?php

$lang = array (
'operate_error'					=>"没有选择操作对象",
'form_error'					=>"表单没有填写完整",

'undefined_action'				=>"非法操作，请返回",
'check_error'					=>'认证码不正确或已过期',
'login_pwd_error'				=>"密码错误，您还可以尝试 $L_T 次",
'login_forbid'					=>"已经连续 6 次密码输入错误,您将在 10 分钟内无法正常登录,还剩余 $L_T 秒",
'login_jihuo'					=>"你的帐号没有激活，请联系管理员激活帐号!",
'login_empty'					=>"用户名或密码为空",
'login_have'					=>"您已经为会员身份，请不要重复登录",

'ip_change'						=>"用户密码已更改, 需要重新登录",

'not_login'						=>"您还没有登录或注册，暂时不能使用此功能",
'user_not_exists'				=>"用户<strong>{$errorname}</strong>不存在",
'guest_info'					=>"无法查看游客的个人资料",
'profile_error'					=>"您没有查看会员资料的权限",

'illegal_customimg'				=>"自定义头像地址必须以http开头",

'pro_custom_fail'				=>"要使用自定义头像功能前提: 请先删除上传的头像",
'pro_loadimg_fail'				=>"您已经上传过头像，要重新上传头像请先删除原来上传的头像",
'pro_loadimg_limit'				=>"上传的头像超过指定大小$db_iconsize KB",
'pro_loadimg_ext'				=>"只允许上传 jpg/jpeg/png/bmp/gif 类型的文件",

'reg_username_limit'			=>"注册名长度错误，请控制在 $rg_regminname - $rg_regmaxname 字节以内",
'reg_repeat'					=>"您已经是注册成员，请不要重复注册",
'reg_close'						=>"对不起，目前网站禁止新用户注册，请返回",

'illegal_username'				=>"此用户名包含不可接受字符或被管理员屏蔽，请选择其它用户名",
'illegal_password'				=>"密码包含不可接受字符，请使用英文和数字",
'illegal_email'					=>"E-Mail信箱没有填写或不符合检查标准，请确认没有错误",
'username_same'					=>"此用户名已经被注册，请选择其它用户名",
'honor_limit'					=>"自定义头衔长度不可超过 $rg_regmaxhonor 字节",
'sign_limit'					=>"签名不可超过 $rg_regmaxsign 字节",
'password_confirm'				=>"两次密码输入不一致，请重新输入",
'not_password'		    		=>"密码不能小于6个字符",
'not_oldpwd'		    		=>"请填写原密码",
'pwd_error'		    	    	=>"原密码错误，请重新填写",

'msg_limit'						=>"发送失败，请不要在 $gp_postpertime 秒内连续性的发送短消息",
'msg_subject_limit'				=>"标题不得大于75字节，内容不得大于1500字节",
'msg_empty'						=>"用户名，标题或内容为空",
'msg_error'						=>"该短消息不存在",
'sebox_full'                    =>"您的发件箱容量已满，请删除部分信息",

'group_read'					=>"您所在的用户组不具备浏览视频的权限",
'group_play'					=>"您所在的用户组不具备播放视频的权限",
'group_post'					=>"您所在的用户组不具备发布视频的权限",
'group_msg_post'				=>"您所在的用户组不具备发送短消息权限",
'group_msg_max'					=>"您所在的用户组不具备发送短消息权限 (最大短消息数目<=0)",

'class_illegal'					=>"无效的类别ID",
'class_error'					=>"您要访问的类别不存在",
'classpw_pwd_error'				=>"密码错误,请重新输入密码",
'classpw_guest'					=>"游客无权登录加密版块",
'class_guest'					=>"此栏目为正规栏目，只允许会员访问",
'class_visit'					=>"对不起，本栏目为认证版块，您没有访问此栏目的权限",
'class_guestlimit'				=>"对不起，本栏目只允许注册会员进入",
'class_creditlimit'				=>"该版块设置了限制积分访问，以下积分为访问该版块需要的最低积分要求<br /><br />
									<table align=\"center\" border=1>
									<tr><td width=\"100\">积分名称</td><td width=\"100\">积分要求</td><td width=\"100\">您现在的积分</td></tr>
									<tr><td>威望</td><td>{$class[$cid][rvrcneed]}</td><td>{$data[rvrc]}</td></tr>
									<tr><td>金钱</td><td>{$class[$cid][moneyneed]}</td><td>{$data[money]}</td></tr>
									<tr><td>发贴数</td><td>{$class[$cid][postneed]}</td><td>{$data[postnum]}</td></tr>
									</table>",
'read_guest'					=>"此视频属于正规栏目，只允许会员访问",
'read_visit'					=>"对不起，您访问的视频属于认证栏目，您没有访问此栏目的权限",
'read_guestlimit'				=>"对不起，视频所在的栏目只允许注册会员进入",
'read_password'					=>"对不起，此视频所在的栏目需要密码才能访问",

'ban_info'  					=>"未验证用户不能发布视频",
'post_type'  					=>"频道等级不能发表新视频，请选择频道的下级栏目",
'post_guest'					=>"所属栏目为正规版块，只允许会员发布视频",
'post_noper'					=>"所属栏目为认证栏目，您不具备在此栏目发布视频的权限",

'play_guest'					=>"您播放的视频属于正规栏目，只允许会员播放",
'play_noper'					=>"您播放的视频属于认证栏目，您没有访问此栏目的权限",
'play_credit_buy'				=>"您播放的视频还没有购买",
'play_credit_need'				=>"您还没有达到播放此视频的积分要求",
'play_guestlimit'				=>"对不起，本视频只允许注册会员播放",
'play_creditlimit'				=>"您还没有达到视频所在栏目的积分要求",
'play_password'					=>"视频所在栏目需要密码才能访问",

'video_illegal'					=>"无效的视频ID",
'video_error'					=>"您要访问的视频不存在",
'video_nosale'					=>"您要访问视频无需购买",
'video_sale_error'				=>"积分不够，无法购买视频",
'video_sale_success'			=>"恭喜，购买成功",

'del_error'						=>"没有选择要删除的选项",
'del_success'					=>"完成删除操作",

'modify_vod_error'				=>"您不具备编辑此视频的权限",
'delete_vod_error'				=>"您不具备删除此视频的权限",

'upload_closs' 					=>"上传功能已关闭",

'vodpic_type_error'				=>"海报 {$img_name} 的类型不符合要求",
'vodpic_size_error'				=>"海报 {$img_name} 超过指定大小 {$db_picmaxsize} 字节",
'attach_type_error'				=>"附件 {$attach_name} 的类型不符合要求",
'attach_size_error'				=>"附件 {$attach_name} 超过指定大小 {$db_attmaxsize} 字节",

'data_error'					=>"您要访问的链接无效",
'have_report'					=>"视频您已经举报过了，谢谢参与",

'no_condition'					=>"条件不足，请填写关键词",
'reply_empty'					=>"您还没有填写评论内容",

'hack_hidden'					=>'插件没有被启用',
'hack_error'					=>'未安装此插件或此插件无前台显示!',
'medal_close'					=>'系统没有开启勋章功能',
'medal_dellog'					=>'只有管理员才能删除勋章颁发日志',
'medallog_del_error'			=>"该勋章未到期，不能删除日志!",
'medal_groupright'				=>'您所属的用户组没有颁发（收回）勋章的权限',
'medal_noreason'				=>'请输入操作理由！',
'medal_nomedal'					=>'请选择要授予的勋章！',
'medal_alreadyhave'				=>'该用户已经已经拥有此勋章',
'medal_none'					=>'该用户没有此勋章',
);
?>