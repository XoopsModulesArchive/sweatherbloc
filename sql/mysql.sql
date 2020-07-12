CREATE TABLE sweatherbloc_config (
  swbid int(8) NOT NULL,
  citycode varchar(8) NOT NULL default '',
  cityname text NOT NULL,
  allowdetails varchar(1) NOT NULL,
  tempunit varchar(1) NOT NULL,
  PRIMARY KEY  (swbid)
) TYPE=MyISAM;

CREATE TABLE sweatherbloc_datacache (
  citycode varchar(8) NOT NULL,
  date int NOT NULL,
  data text NOT NULL,
  PRIMARY KEY  (citycode)
) TYPE=MyISAM;
