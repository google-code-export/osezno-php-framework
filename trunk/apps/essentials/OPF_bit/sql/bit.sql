SELECT 
	ess_bit.id as "{OPF_FIELD_ID}", 
	ess_bit.datetime as "{OPF_FIELD_DATETIME}", 
	ess_bit.ip as "{OPF_FIELD_IP}", 
	ess_bit.url as "{OPF_FIELD_URL}", 
	ess_system_users.user_name as "{OPF_FIELD_USUARIO}"  
FROM ess_bit
	LEFT OUTER JOIN ess_system_users ON (ess_bit.usuario_id = ess_system_users.id)