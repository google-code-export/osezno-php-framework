select 
	ess_master_tables.id as "{OPF_FIELD_MODIFICAR}",
	ess_master_tables.id as "{OPF_FIELD_ELIMINAR}",
	ess_master_tables.name as "{OPF_FIELD_TABLA}",
	ess_system_users.user_name as "{OPF_FIELD_USUARIO}",
	ess_master_tables.datetime as "{OPF_FIELD_ACTUALIZADO}",
	ess_master_tables.id as "{OPF_FIELD_DETALLE}",
	ess_master_tables.id as "{OPF_ADMTABLAS_8}"
from ess_master_tables
	inner join ess_system_users on (ess_master_tables.user_id = ess_system_users.id)