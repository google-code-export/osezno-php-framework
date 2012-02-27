SELECT
	ess_usronline.id AS "{OPF_FIELD_CERRAR}",
	ess_system_users.user_name as "{OPF_FIELD_USUARIO}",
	ess_usronline.ip as "{OPF_FIELD_IP}",
	ess_usronline.datetime as "{OPF_FIELD_INGRESO}",
	ess_usronline.sesname as "{OPF_FIELD_FILE}",
	ess_usronline.size as "{OPF_FIELD_PESO}",
	ess_usronline.filectime as "{OPF_FIELD_ACTUALIZADO}"
FROM ess_usronline 
	INNER JOIN ess_system_users ON (ess_usronline.usuario_id = ess_system_users.id) 