drop database if exists tracking;
create database tracking;
use tracking;

create table video(
    id                  int unsigned auto_increment primary key,
    title               varchar(50) not null,
    description         text not null,
    duration_seconds    int unsigned not null,
    video_url           varchar(255) not null,
    is_active           boolean not null default true,
    created_at          datetime not null default current_timestamp,
    updated_at          datetime null on update current_timestamp
)ENGINE = InnoDB;

CREATE TABLE video_tracking (
    id             	INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id         INT(10) UNSIGNED NOT NULL,
    course_id       INT(10) UNSIGNED NOT NULL,
    video_id        INT(10) UNSIGNED NOT NULL,
    watched_seconds INT(10) UNSIGNED NOT NULL DEFAULT 0,
    percentage      DECIMAL(5,2)     NOT NULL DEFAULT 0.00,
    status         	ENUM('not started', 'in progress', 'completed') NOT NULL DEFAULT 'not started',
    started_at      DATETIME         NULL DEFAULT NULL,
    completed_at    DATETIME         NULL DEFAULT NULL,
    last_activity   DATETIME         NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at     DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    foreign key (video_id) references video(id),
    UNIQUE KEY unique_user_video (user_id, course_id, video_id),
    INDEX idx_status (status)
) ENGINE=InnoDB;