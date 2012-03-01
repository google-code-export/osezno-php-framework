SELECT 
	ess_profiles.id as "{OPF_FIELD_MODIFICAR}", 
	ess_profiles.id as "{OPF_FIELD_ELIMINAR}", 
	ess_profiles.name as "{OPF_FIELD_PERFIL}", 
	ess_profiles.description as "{OPF_FIELD_DESCRIPCION}",
	ess_system_users.user_name as "{OPF_FIELD_USUARIO}",
	ess_profiles.datetime as "{OPF_FIELD_DATETIME}",
	ess_profiles.id as "{OPF_FIELD_MENU}"
FROM ess_profiles
	INNER JOIN ess_system_users ON (ess_profiles.user_id = ess_system_users.id)