SELECT ess_system_users.id as "{OPF_FIELD_MODIFICAR}", 
	ess_system_users.id as "{OPF_FIELD_ELIMINAR}", 
	ess_system_users.user_name as "{OPF_FIELD_USUARIO}", 
	ess_system_users.name as "{OPF_FIELD_NOMBRE}", 
	ess_system_users.lastname as "{OPF_FIELD_APELLIDO}",
	ess_system_users.datetime as "{OPF_FIELD_ACTUALIZADO}",
	ess_profiles.name as "{OPF_FIELD_PERFIL}",
	CASE ess_system_users.status 
		WHEN 1 THEN '{OPF_ADMUSR_11}'
		WHEN 2 THEN '{OPF_ADMUSR_10}' 
		END as "{OPF_FIELD_ESTADO}"
FROM ess_system_users
	INNER JOIN ess_profiles ON (ess_system_users.profile_id = ess_profiles.id)