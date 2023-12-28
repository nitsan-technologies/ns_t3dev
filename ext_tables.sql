CREATE TABLE tx_nst3dev_domain_model_productarea
(
	name        varchar(255) NOT NULL DEFAULT '',
	image       int(11) unsigned NOT NULL DEFAULT '0',
	description text,
	slug        varchar(255) NOT NULL DEFAULT '',
	type        varchar(255) NOT NULL DEFAULT '',
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
	KEY language (l10n_parent,sys_language_uid)
);
