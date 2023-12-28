CREATE TABLE tx_nst3dev_domain_model_productarea (
	name varchar(255) NOT NULL DEFAULT '',
	description text,
);



CREATE TABLE tx_nst3dev_domain_model_log
(
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	level tinyint(1) unsigned DEFAULT '0' NOT NULL,
	message text,
	data text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);
