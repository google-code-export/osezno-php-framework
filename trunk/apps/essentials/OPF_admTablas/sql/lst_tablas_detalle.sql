select 
	ess_master_tables_detail.id as "{OPF_FIELD_MODIFICAR}",
	ess_master_tables_detail.id as "{OPF_FIELD_ELIMINAR}",
	ess_master_tables_detail.item_cod as "{OPF_FIELD_CODIGO}",
	ess_master_tables_detail.item_desc as "{OPF_FIELD_DESCRIPCION}",
	ess_system_users.user_name as "{OPF_FIELD_USUARIO}",
	ess_master_tables_detail.datetime as "{OPF_FIELD_ACTUALIZADO}"
from ess_master_tables_detail
	inner join ess_system_users on (ess_master_tables_detail.user_id = ess_system_users.id)
WHERE ess_master_tables_detail.master_tables_id = {master_tables_id}