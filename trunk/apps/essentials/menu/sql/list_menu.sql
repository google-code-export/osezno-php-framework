SELECT 
	ess_menu.id as "{OPF_FIELD_MODIFICAR}",
	ess_menu.id as "{OPF_FIELD_ELIMINAR}",
	ess_menu.id as "{OPF_FIELD_ID}",
	same.description as "{OPF_FIELD_PADRE}",
	ess_menu.description as "{OPF_FIELD_DESCRIPCION}",
	ess_menu.icon as "{OPF_FIELD_ICON}",
	ess_menu.url as "{OPF_FIELD_URL}",
	ess_menu.ord as "{OPF_FIELD_ORDEN}",
	ess_system_users.user_name as "{OPF_FIELD_USUARIO}",
	ess_menu.datetime as "{OPF_FIELD_DATETIME}"
FROM ess_menu
	INNER JOIN ess_system_users ON (ess_menu.usuario_id = ess_system_users.id)
	LEFT OUTER JOIN ess_menu same ON (same.id = ess_menu.menu_id)
