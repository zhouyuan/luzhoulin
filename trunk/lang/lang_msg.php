<?php

$lang = array (
'operate_error'					=>"û��ѡ���������",
'form_error'					=>"��û����д����",

'undefined_action'				=>"�Ƿ��������뷵��",
'check_error'					=>'��֤�벻��ȷ���ѹ���',
'login_pwd_error'				=>"��������������Գ��� $L_T ��",
'login_forbid'					=>"�Ѿ����� 6 �������������,������ 10 �������޷�������¼,��ʣ�� $L_T ��",
'login_jihuo'					=>"����ʺ�û�м������ϵ����Ա�����ʺ�!",
'login_empty'					=>"�û���������Ϊ��",
'login_have'					=>"���Ѿ�Ϊ��Ա��ݣ��벻Ҫ�ظ���¼",

'ip_change'						=>"�û������Ѹ���, ��Ҫ���µ�¼",

'not_login'						=>"����û�е�¼��ע�ᣬ��ʱ����ʹ�ô˹���",
'user_not_exists'				=>"�û�<strong>{$errorname}</strong>������",
'guest_info'					=>"�޷��鿴�ο͵ĸ�������",
'profile_error'					=>"��û�в鿴��Ա���ϵ�Ȩ��",

'illegal_customimg'				=>"�Զ���ͷ���ַ������http��ͷ",

'pro_custom_fail'				=>"Ҫʹ���Զ���ͷ����ǰ��: ����ɾ���ϴ���ͷ��",
'pro_loadimg_fail'				=>"���Ѿ��ϴ���ͷ��Ҫ�����ϴ�ͷ������ɾ��ԭ���ϴ���ͷ��",
'pro_loadimg_limit'				=>"�ϴ���ͷ�񳬹�ָ����С$db_iconsize KB",
'pro_loadimg_ext'				=>"ֻ�����ϴ� jpg/jpeg/png/bmp/gif ���͵��ļ�",

'reg_username_limit'			=>"ע�������ȴ���������� $rg_regminname - $rg_regmaxname �ֽ�����",
'reg_repeat'					=>"���Ѿ���ע���Ա���벻Ҫ�ظ�ע��",
'reg_close'						=>"�Բ���Ŀǰ��վ��ֹ���û�ע�ᣬ�뷵��",

'illegal_username'				=>"���û����������ɽ����ַ��򱻹���Ա���Σ���ѡ�������û���",
'illegal_password'				=>"����������ɽ����ַ�����ʹ��Ӣ�ĺ�����",
'illegal_email'					=>"E-Mail����û����д�򲻷��ϼ���׼����ȷ��û�д���",
'username_same'					=>"���û����Ѿ���ע�ᣬ��ѡ�������û���",
'honor_limit'					=>"�Զ���ͷ�γ��Ȳ��ɳ��� $rg_regmaxhonor �ֽ�",
'sign_limit'					=>"ǩ�����ɳ��� $rg_regmaxsign �ֽ�",
'password_confirm'				=>"�����������벻һ�£�����������",
'not_password'		    		=>"���벻��С��6���ַ�",
'not_oldpwd'		    		=>"����дԭ����",
'pwd_error'		    	    	=>"ԭ���������������д",

'msg_limit'						=>"����ʧ�ܣ��벻Ҫ�� $gp_postpertime ���������Եķ��Ͷ���Ϣ",
'msg_subject_limit'				=>"���ⲻ�ô���75�ֽڣ����ݲ��ô���1500�ֽ�",
'msg_empty'						=>"�û��������������Ϊ��",
'msg_error'						=>"�ö���Ϣ������",
'sebox_full'                    =>"���ķ�����������������ɾ��������Ϣ",

'group_read'					=>"�����ڵ��û��鲻�߱������Ƶ��Ȩ��",
'group_play'					=>"�����ڵ��û��鲻�߱�������Ƶ��Ȩ��",
'group_post'					=>"�����ڵ��û��鲻�߱�������Ƶ��Ȩ��",
'group_msg_post'				=>"�����ڵ��û��鲻�߱����Ͷ���ϢȨ��",
'group_msg_max'					=>"�����ڵ��û��鲻�߱����Ͷ���ϢȨ�� (������Ϣ��Ŀ<=0)",

'class_illegal'					=>"��Ч�����ID",
'class_error'					=>"��Ҫ���ʵ���𲻴���",
'classpw_pwd_error'				=>"�������,��������������",
'classpw_guest'					=>"�ο���Ȩ��¼���ܰ��",
'class_guest'					=>"����ĿΪ������Ŀ��ֻ�����Ա����",
'class_visit'					=>"�Բ��𣬱���ĿΪ��֤��飬��û�з��ʴ���Ŀ��Ȩ��",
'class_guestlimit'				=>"�Բ��𣬱���Ŀֻ����ע���Ա����",
'class_creditlimit'				=>"�ð�����������ƻ��ַ��ʣ����»���Ϊ���ʸð����Ҫ����ͻ���Ҫ��<br /><br />
									<table align=\"center\" border=1>
									<tr><td width=\"100\">��������</td><td width=\"100\">����Ҫ��</td><td width=\"100\">�����ڵĻ���</td></tr>
									<tr><td>����</td><td>{$class[$cid][rvrcneed]}</td><td>{$data[rvrc]}</td></tr>
									<tr><td>��Ǯ</td><td>{$class[$cid][moneyneed]}</td><td>{$data[money]}</td></tr>
									<tr><td>������</td><td>{$class[$cid][postneed]}</td><td>{$data[postnum]}</td></tr>
									</table>",
'read_guest'					=>"����Ƶ����������Ŀ��ֻ�����Ա����",
'read_visit'					=>"�Բ��������ʵ���Ƶ������֤��Ŀ����û�з��ʴ���Ŀ��Ȩ��",
'read_guestlimit'				=>"�Բ�����Ƶ���ڵ���Ŀֻ����ע���Ա����",
'read_password'					=>"�Բ��𣬴���Ƶ���ڵ���Ŀ��Ҫ������ܷ���",

'ban_info'  					=>"δ��֤�û����ܷ�����Ƶ",
'post_type'  					=>"Ƶ���ȼ����ܷ�������Ƶ����ѡ��Ƶ�����¼���Ŀ",
'post_guest'					=>"������ĿΪ�����飬ֻ�����Ա������Ƶ",
'post_noper'					=>"������ĿΪ��֤��Ŀ�������߱��ڴ���Ŀ������Ƶ��Ȩ��",

'play_guest'					=>"�����ŵ���Ƶ����������Ŀ��ֻ�����Ա����",
'play_noper'					=>"�����ŵ���Ƶ������֤��Ŀ����û�з��ʴ���Ŀ��Ȩ��",
'play_credit_buy'				=>"�����ŵ���Ƶ��û�й���",
'play_credit_need'				=>"����û�дﵽ���Ŵ���Ƶ�Ļ���Ҫ��",
'play_guestlimit'				=>"�Բ��𣬱���Ƶֻ����ע���Ա����",
'play_creditlimit'				=>"����û�дﵽ��Ƶ������Ŀ�Ļ���Ҫ��",
'play_password'					=>"��Ƶ������Ŀ��Ҫ������ܷ���",

'video_illegal'					=>"��Ч����ƵID",
'video_error'					=>"��Ҫ���ʵ���Ƶ������",
'video_nosale'					=>"��Ҫ������Ƶ���蹺��",
'video_sale_error'				=>"���ֲ������޷�������Ƶ",
'video_sale_success'			=>"��ϲ������ɹ�",

'del_error'						=>"û��ѡ��Ҫɾ����ѡ��",
'del_success'					=>"���ɾ������",

'modify_vod_error'				=>"�����߱��༭����Ƶ��Ȩ��",
'delete_vod_error'				=>"�����߱�ɾ������Ƶ��Ȩ��",

'upload_closs' 					=>"�ϴ������ѹر�",

'vodpic_type_error'				=>"���� {$img_name} �����Ͳ�����Ҫ��",
'vodpic_size_error'				=>"���� {$img_name} ����ָ����С {$db_picmaxsize} �ֽ�",
'attach_type_error'				=>"���� {$attach_name} �����Ͳ�����Ҫ��",
'attach_size_error'				=>"���� {$attach_name} ����ָ����С {$db_attmaxsize} �ֽ�",

'data_error'					=>"��Ҫ���ʵ�������Ч",
'have_report'					=>"��Ƶ���Ѿ��ٱ����ˣ�лл����",

'no_condition'					=>"�������㣬����д�ؼ���",
'reply_empty'					=>"����û����д��������",

'hack_hidden'					=>'���û�б�����',
'hack_error'					=>'δ��װ�˲����˲����ǰ̨��ʾ!',
'medal_close'					=>'ϵͳû�п���ѫ�¹���',
'medal_dellog'					=>'ֻ�й���Ա����ɾ��ѫ�°䷢��־',
'medallog_del_error'			=>"��ѫ��δ���ڣ�����ɾ����־!",
'medal_groupright'				=>'���������û���û�а䷢���ջأ�ѫ�µ�Ȩ��',
'medal_noreason'				=>'������������ɣ�',
'medal_nomedal'					=>'��ѡ��Ҫ�����ѫ�£�',
'medal_alreadyhave'				=>'���û��Ѿ��Ѿ�ӵ�д�ѫ��',
'medal_none'					=>'���û�û�д�ѫ��',
);
?>