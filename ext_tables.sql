CREATE TABLE tx_pinlogin_domain_model_pin (
    uid int(11) unsigned NOT NULL auto_increment,
    pid int(11) DEFAULT 0 NOT NULL,

    feuser_id int(11) DEFAULT '0' NOT NULL,
    pin varchar(4) DEFAULT NULL,
    UNIQUE KEY page_pin (pid, pin),

    cruser_id int(11) unsigned DEFAULT 0 NOT NULL,
    tstamp int(11) unsigned DEFAULT 0 NOT NULL,
    crdate int(11) unsigned DEFAULT 0 NOT NULL,
    deleted tinyint(4) unsigned DEFAULT 0 NOT NULL,
    hidden tinyint(4) unsigned DEFAULT 0 NOT NULL,
    sys_language_uid int(11) DEFAULT 0 NOT NULL,
    l18n_parent int(11) DEFAULT 0 NOT NULL,
    l18n_diffsource mediumblob DEFAULT NULL,
    fe_group int(11) DEFAULT 0 NOT NULL,
    parent_id int(11) DEFAULT 0 NOT NULL,

    sorting int(11) DEFAULT '0' NOT NULL,

    l10n_parent mediumblob DEFAULT NULL,
    starttime int(11) DEFAULT '0' NOT NULL,
    endtime int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);