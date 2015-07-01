
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- tnt_france_
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tnt_france_`;

CREATE TABLE `tnt_france_`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_id` INTEGER,
    `message_id` INTEGER,
    `message` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tnt_order_parcel_response
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tnt_order_parcel_response`;

CREATE TABLE `tnt_order_parcel_response`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_product_id` INTEGER NOT NULL,
    `pick_up_number` INTEGER NOT NULL,
    `file_name` VARCHAR(255),
    `sequence_number` INTEGER NOT NULL,
    `parcel_number_id` INTEGER,
    `sticker_number` INTEGER,
    `tracking_url` VARCHAR(255) NOT NULL,
    `printed` TINYINT DEFAULT 0,
    `weight` FLOAT DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `tnt_order_parcel_response_FI_1` (`order_product_id`),
    CONSTRAINT `tnt_order_parcel_response_FK_1`
        FOREIGN KEY (`order_product_id`)
        REFERENCES `order_product` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
