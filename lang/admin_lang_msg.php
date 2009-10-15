<?php

$lang = array (

'check_error'				=>'认证码错误',
'login_error'				=>"密码错误,您还可以尝试{$L_left}次",
'login_fail'				=>"连续 $F_count 次进行无效登陆,<br>您将在 20 分钟内无法登陆后台<br>还剩余 $L_T 秒",

'installfile_exists'		=>"install.php 文件仍然在您的服务器上，请将其删除！",

'undefine_action'			=>'您没有权限进行此项操作或此功能未完成',
'operate_error'				=>"没有选择操作对象",
'operate_success'			=>"完成相应操作",
'operate_fail'				=>"操作失败，请检查数据完整性",

'user_not_exists'			=>"用户{$errorname}不存在",
'password_confirm'			=>'两次输入密码不一致，请重新输入',
'illegal_username'			=>"用户名太长或包含不可接受字符",
'illegal_password'			=>"密码包含不可接受字符",
'illegal_email'				=>"email格式错误",
'username_exists'			=>"该用户名已经被注册了,请返回重新填写.",

'log_min'					=>"管理日志少于100不允许删除!!",
'log_del'					=>"已删除多余的管理日志",

'setting_http'				=>"使用跨台图片链必须以http开头",
'config_777'				=>"<font color=red>无法修改论坛核心,请将 data/cache/config.php 文件属性设为可写模式(777)</font>",
'setting_777'				=>'<font color=red>无法更改图片或附件目录名,请设置其属性为可写模式(777)</font>',

'board_havesub'				=>"该栏目含有子栏目，请先转移所有子栏目，再进行此操作",
'board_havevod'				=>"该栏目下含有视频，请先转移或删除所有视频，再进行此操作",
'board_fupsame'		    	=>'不能将所属上级分类设为自己',
'board_fupsub'				=>'不能将所属项目设置为自己的子项目',
'unite_same'				=>"源和目标不能相同",
'board_selerror' 			=>"请重新选择栏目(不能选择频道级别的栏目)",

'style_add_success'			=>"添加风格完成",
'style_exists'				=>"此名称已存在，请另选名称",
'style_del_error'			=>"不能删除默认风格,请先更换默认风格",
'style_not_exists'			=>"此风格不存在",

'noenough_condition'		=>'没有提供足够的条件',

'setuser_boardadmin'		=>"设置或取消会员的版主权限，请到<font color='red'>版块管理</font>处设置",
'setuser_ban'				=>"封禁用户和解除禁言请到会员禁言处设置",
'setuser_empty'				=>"用户名,密码或email为空",
'setuser_img'				=>"头像网址必须以 'http' 开头.",

'credit_error'				=>'无效积分ID',

'bakup_in'					=>"正在导入第{$i}卷备份文件，程序将自动导入余下备份文件...",
'bakup_out'					=>"已全部备份,备份文件保存在data目录下，备份文件为<br>$bakfile",
'bakup_step'				=>"正在备份数据库表 $t_name: 共 $rows 条记录，已经备份至 $c_n  条记录<br><br>已生成 $f_num 个备份文件，程序将自动备份余下部分",

'level_del'					=>"不能删除默认组",

'hackcenter_empty'			=>"插件信息不完整，请重新填写！",
'hackcentre_upload'         =>"找不到插件文件,请先上传文件!",
'hackcenter_sign_exists'	=>"插件标识符{$directory}已经存在，请另外选择标识符",
'hack_error'				=>'未安装此插件或此插件无后台设置!',
'hackcenter_del_fail'       =>"插件卸载完成删除以下文件夹失败，请手动删除<br> hack 目录下的 {$hack[$directory][directory]} 目录",
'hackcenter_edit_fail'		=>"插件编辑成功，请手动把 hack 目录下的 {$hackdir} 重命名为 {$directory}",
);
?>