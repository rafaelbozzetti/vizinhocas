<?php
//queries used by tests
return array(
    'manifest' => array(
        'create' => 'CREATE  TABLE if not exists manifest (
                      id INT NOT NULL AUTO_INCREMENT ,
                      title VARCHAR(250) NOT NULL ,
                      description TEXT NOT NULL ,
                      post_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                      PRIMARY KEY (id) )
                    ENGINE = InnoDB;',
        'drop' => "DROP TABLE manifest;"
    ),
    'intention' => array(
        'create' => 'CREATE  TABLE if not exists intention (
                      id INT NOT NULL AUTO_INCREMENT ,
                      post_id INT NOT NULL ,
                      description TEXT NOT NULL ,
                      name VARCHAR(200) NOT NULL ,
                      email VARCHAR(250) NOT NULL ,                      
                      comment_date TIMESTAMP NULL ,
                        PRIMARY KEY (id, post_id) ,
                        INDEX fk_intentions_manifest (post_id ASC) ,
                      CONSTRAINT fk_intentions_manifest
                        FOREIGN KEY (post_id )
                           REFERENCES manifest (id )
                           ON DELETE NO ACTION
                           ON UPDATE NO ACTION)
                    ENGINE = InnoDB;',
        'drop' =>'drop table intention;'
    ),
);