SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `addresses`
(
    `id`            bigint(20) UNSIGNED NOT NULL,
    `address_name`  varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `address`       varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `city`          varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `zipcode`       varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `country`       varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `user_id`       bigint(20) UNSIGNED DEFAULT NULL,
    `partner_id`    bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `agendas`
(
    `id`               bigint(20) UNSIGNED NOT NULL,
    `space_id`         bigint(20) UNSIGNED DEFAULT NULL,
    `name`             varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Agenda',
    `partner_id`       bigint(20) UNSIGNED NOT NULL,
    `last_verified_at` timestamp NULL DEFAULT NULL,
    `created_at`       timestamp NULL DEFAULT NULL,
    `updated_at`       timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `agenda_elements`
(
    `id`                  bigint(20) UNSIGNED NOT NULL,
    `start`               timestamp NULL DEFAULT NULL,
    `end`                 timestamp                               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `agenda_id`           bigint(20) UNSIGNED DEFAULT NULL,
    `estimate_id`         bigint(20) UNSIGNED DEFAULT NULL,
    `booking_id`          bigint(20) UNSIGNED DEFAULT NULL,
    `status`              varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `name`                varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `estimate_request_id` bigint(20) UNSIGNED DEFAULT NULL,
    `booking_request_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `articles`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `name`        varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `unit_price`  double                                  NOT NULL,
    `vat_rate`    double                                  NOT NULL,
    `description` text COLLATE utf8mb4_unicode_ci         NOT NULL,
    `sellsy_id`   varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `bookings`
(
    `id`                  bigint(20) UNSIGNED NOT NULL,
    `status`              varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'planned',
    `estimate_id`         bigint(20) UNSIGNED DEFAULT NULL,
    `amount_paid`         double                                           DEFAULT NULL,
    `amount_total`        double                                           DEFAULT NULL,
    `amount_invoiced`     double                                  NOT NULL DEFAULT '0',
    `starts_at`           timestamp NULL DEFAULT NULL,
    `ends_at`             timestamp NULL DEFAULT NULL,
    `user_id`             bigint(20) UNSIGNED DEFAULT NULL,
    `has_problems`        tinyint(1) NOT NULL DEFAULT '0',
    `created_at`          timestamp NULL DEFAULT NULL,
    `updated_at`          timestamp NULL DEFAULT NULL,
    `internal_note`       varchar(10000) COLLATE utf8mb4_unicode_ci        DEFAULT NULL,
    `old_site_id`         varchar(60) COLLATE utf8mb4_unicode_ci           DEFAULT NULL,
    `organization_id`     bigint(20) UNSIGNED DEFAULT NULL,
    `er_referent_id`      bigint(20) UNSIGNED DEFAULT NULL,
    `cancellation_reason` varchar(120) COLLATE utf8mb4_unicode_ci          DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `booking_partners`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `booking_id` bigint(20) UNSIGNED NOT NULL,
    `partner_id` bigint(20) UNSIGNED DEFAULT NULL,
    `status`     varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unconfirmed',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `discounts`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `model_type`  varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `model_id`    bigint(20) UNSIGNED NOT NULL,
    `value`       double                                  NOT NULL,
    `type`        enum('amount','percentage') COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `starts_at`   timestamp                               NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `ends_at`     timestamp NULL DEFAULT NULL,
    `created_by`  bigint(20) UNSIGNED NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `estimates`
(
    `id`                  bigint(20) UNSIGNED NOT NULL,
    `user_id`             bigint(20) UNSIGNED DEFAULT NULL,
    `pdf`                 varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `yousign_pdf_url`     varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `yousign_procedure`   varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `signed`              tinyint(1) NOT NULL DEFAULT '0',
    `status`              varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cart',
    `amount_paid`         double                                  NOT NULL DEFAULT '0',
    `amount_total`        double                                  NOT NULL DEFAULT '0',
    `booking_date`        timestamp NULL DEFAULT NULL,
    `qty_hours`           int(11) NOT NULL DEFAULT '0',
    `billing_address_id`  bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`          timestamp NULL DEFAULT NULL,
    `updated_at`          timestamp NULL DEFAULT NULL,
    `sellsy_id`           varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `auto_deposit`        tinyint(1) NOT NULL DEFAULT '0',
    `estimate_request_id` bigint(20) UNSIGNED DEFAULT NULL,
    `internal_note`       varchar(10000) COLLATE utf8mb4_unicode_ci        DEFAULT NULL,
    `estimate_file`       varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `organization_id`     bigint(20) UNSIGNED DEFAULT NULL,
    `er_referent_id`      bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `estimate_activities`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `user_id`     bigint(20) UNSIGNED DEFAULT NULL,
    `estimate_id` bigint(20) UNSIGNED NOT NULL,
    `text`        varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
    `type`        varchar(100) COLLATE utf8mb4_unicode_ci  NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `estimate_elements`
(
    `id`               bigint(20) UNSIGNED NOT NULL,
    `estimate_id`      bigint(20) UNSIGNED NOT NULL,
    `booking_id`       bigint(20) UNSIGNED DEFAULT NULL,
    `offer_id`         bigint(20) UNSIGNED DEFAULT NULL,
    `offer_element_id` bigint(20) UNSIGNED DEFAULT NULL,
    `space_id`         bigint(20) UNSIGNED DEFAULT NULL,
    `description`      varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `unit_price`       double                                  NOT NULL DEFAULT '0',
    `tax_rate`         double                                  NOT NULL DEFAULT '20',
    `partner_id`       bigint(20) UNSIGNED DEFAULT NULL,
    `agenda_id`        bigint(20) UNSIGNED DEFAULT NULL,
    `quantity`         int(10) UNSIGNED NOT NULL,
    `amount_paid`      double                                  NOT NULL DEFAULT '0',
    `starts_at`        timestamp                               NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `ends_at`          timestamp                               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_at`       timestamp NULL DEFAULT NULL,
    `updated_at`       timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `estimate_files`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `filename`    varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `name`        varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `type`        varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `estimate_id` bigint(20) UNSIGNED DEFAULT NULL,
    `booking_id`  bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `estimate_requests`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `name`       varchar(191) COLLATE utf8mb4_unicode_ci   NOT NULL,
    `company`    varchar(191) COLLATE utf8mb4_unicode_ci   NOT NULL,
    `phone`      varchar(191) COLLATE utf8mb4_unicode_ci            DEFAULT NULL,
    `email`      varchar(191) COLLATE utf8mb4_unicode_ci            DEFAULT NULL,
    `start`      date                                      NOT NULL,
    `end`        date                                      NOT NULL,
    `space_id`   bigint(20) UNSIGNED DEFAULT NULL,
    `time`       varchar(191) COLLATE utf8mb4_unicode_ci   NOT NULL,
    `message`    varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `status`     varchar(191) COLLATE utf8mb4_unicode_ci   NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `uuid`       varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `connection` text COLLATE utf8mb4_unicode_ci         NOT NULL,
    `queue`      text COLLATE utf8mb4_unicode_ci         NOT NULL,
    `payload`    longtext COLLATE utf8mb4_unicode_ci     NOT NULL,
    `exception`  longtext COLLATE utf8mb4_unicode_ci     NOT NULL,
    `failed_at`  timestamp                               NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `invoices`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `user_id`    bigint(20) UNSIGNED DEFAULT NULL,
    `partner_id` bigint(20) UNSIGNED DEFAULT NULL,
    `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
    `address_id` bigint(20) UNSIGNED DEFAULT NULL,
    `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `type`       enum('partner','customer','commission') COLLATE utf8mb4_unicode_ci NOT NULL,
    `ttc_total`  double                                  NOT NULL,
    `status`     varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending_payment',
    `pdf`        varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `invoice_lines`
(
    `id`               bigint(20) UNSIGNED NOT NULL,
    `invoice_id`       bigint(20) UNSIGNED NOT NULL,
    `text`             varchar(3500) COLLATE utf8mb4_unicode_ci NOT NULL,
    `quantity`         int(11) NOT NULL,
    `unit_price`       double                                   NOT NULL,
    `tax_rate`         double                                   NOT NULL,
    `total_price`      double                                   NOT NULL,
    `partner_id`       bigint(20) UNSIGNED DEFAULT NULL,
    `offer_element_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_offers`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `title`       varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
    `slug`        varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` text COLLATE utf8mb4_unicode_ci         NOT NULL,
    `active`      tinyint(1) NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `mails`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `topic`      varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
    `type`       enum('general','support') COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `closed`     tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `mail_messages`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `mail_id`    bigint(20) UNSIGNED NOT NULL,
    `text`       varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL,
    `user_id`    bigint(20) UNSIGNED NOT NULL,
    `read_at`    timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `mail_user`
(
    `id`      bigint(20) UNSIGNED NOT NULL,
    `user_id` bigint(20) UNSIGNED NOT NULL,
    `mail_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `media`
(
    `id`             bigint(20) UNSIGNED NOT NULL,
    `name`           varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `type`           varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `content`        varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `partner_id`     bigint(20) UNSIGNED DEFAULT NULL,
    `space_id`       bigint(20) UNSIGNED DEFAULT NULL,
    `space_group_id` bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL,
    `order`          int(11) DEFAULT NULL,
    `role`           varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `page_id`        bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `notifications`
(
    `id`              char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `type`            varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `notifiable_id`   bigint(20) UNSIGNED NOT NULL,
    `data`            text COLLATE utf8mb4_unicode_ci         NOT NULL,
    `read_at`         timestamp NULL DEFAULT NULL,
    `created_at`      timestamp NULL DEFAULT NULL,
    `updated_at`      timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `offers`
(
    `id`             bigint(20) UNSIGNED NOT NULL,
    `name`           varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `description`    varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `start`          time                                    DEFAULT NULL,
    `stop`           time                                    DEFAULT NULL,
    `space_group_id` bigint(20) UNSIGNED DEFAULT NULL,
    `partner_id`     bigint(20) UNSIGNED NOT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `offer_elements`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `offer_id`    bigint(20) UNSIGNED NOT NULL,
    `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `unit_price`  double                                  NOT NULL DEFAULT '0',
    `unit_type`   varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `optional`    tinyint(1) DEFAULT NULL,
    `tax_rate`    double                                  NOT NULL DEFAULT '20',
    `partner_id`  bigint(20) UNSIGNED NOT NULL,
    `agenda_id`   bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `organizations`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `type`       varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `name`       varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `sellsy_id`  varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pages`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `title`      varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `slug`       varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `meta`       varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
    `content`    text COLLATE utf8mb4_unicode_ci         NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `parent_id`  bigint(20) UNSIGNED DEFAULT NULL,
    `meta_title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `partners`
(
    `id`            bigint(20) UNSIGNED NOT NULL,
    `type`          varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `balance`       double                                  NOT NULL DEFAULT '0',
    `iban`          varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT '',
    `plan`          varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `commission`    int(10) UNSIGNED NOT NULL DEFAULT '0',
    `company`       varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `email`         varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `phone`         varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `website`       varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `is_validated`  tinyint(1) NOT NULL DEFAULT '0',
    `stripe_id`     varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `pm_type`       varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `pm_last_four`  varchar(4) COLLATE utf8mb4_unicode_ci            DEFAULT NULL,
    `trial_ends_at` timestamp NULL DEFAULT NULL,
    `deleted_at`    timestamp NULL DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `partner_balance_events`
(
    `id`              bigint(20) UNSIGNED NOT NULL,
    `partner_id`      bigint(20) UNSIGNED NOT NULL,
    `amount`          double NOT NULL,
    `invoice_line_id` bigint(20) UNSIGNED DEFAULT NULL,
    `comment`         varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at`      timestamp NULL DEFAULT NULL,
    `updated_at`      timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `partner_user`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `user_id`    bigint(20) UNSIGNED NOT NULL,
    `partner_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_resets`
(
    `email`      varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `token`      varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `settings`
(
    `id`    bigint(20) UNSIGNED NOT NULL,
    `key`   varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `spaces`
(
    `id`                  bigint(20) UNSIGNED NOT NULL,
    `name`                varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `presentation`        text COLLATE utf8mb4_unicode_ci,
    `slug`                varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `capacity_min`        int(11) NOT NULL DEFAULT '1',
    `capacity_max`        int(11) NOT NULL DEFAULT '1',
    `area`                int(11) DEFAULT NULL,
    `space_group_id`      bigint(20) UNSIGNED NOT NULL,
    `created_at`          timestamp NULL DEFAULT NULL,
    `updated_at`          timestamp NULL DEFAULT NULL,
    `has_disabled_access` tinyint(1) NOT NULL DEFAULT '0',
    `meta`                varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `meta_title`          varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `sg_slug`             varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
    `active`              tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `space_actions`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `content`    text COLLATE utf8mb4_unicode_ci NOT NULL,
    `resolved`   tinyint(1) NOT NULL DEFAULT '0',
    `space_id`   bigint(20) UNSIGNED NOT NULL,
    `user_id`    bigint(20) UNSIGNED DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `space_groups`
(
    `id`           bigint(20) UNSIGNED NOT NULL,
    `name`         varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `presentation` text COLLATE utf8mb4_unicode_ci,
    `slug`         varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `address`      varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `city`         varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `access`       text COLLATE utf8mb4_unicode_ci,
    `zip_code`     varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `partner_id`   bigint(20) UNSIGNED NOT NULL,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL,
    `meta`         varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `meta_title`   varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `space_tag`
(
    `id`       bigint(20) UNSIGNED NOT NULL,
    `space_id` bigint(20) UNSIGNED NOT NULL,
    `tag_id`   bigint(20) UNSIGNED NOT NULL,
    `details`  varchar(10000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `subscriptions`
(
    `id`            bigint(20) UNSIGNED NOT NULL,
    `partner_id`    bigint(20) UNSIGNED NOT NULL,
    `name`          varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `stripe_id`     varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `stripe_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `stripe_price`  varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `quantity`      int(11) DEFAULT NULL,
    `trial_ends_at` timestamp NULL DEFAULT NULL,
    `ends_at`       timestamp NULL DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `subscription_items`
(
    `id`              bigint(20) UNSIGNED NOT NULL,
    `subscription_id` bigint(20) UNSIGNED NOT NULL,
    `stripe_id`       varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `stripe_product`  varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `stripe_price`    varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `quantity`        int(11) DEFAULT NULL,
    `created_at`      timestamp NULL DEFAULT NULL,
    `updated_at`      timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tags`
(
    `id`   bigint(20) UNSIGNED NOT NULL,
    `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users`
(
    `id`                  bigint(20) UNSIGNED NOT NULL,
    `first_name`          varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `last_name`           varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email`               varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email_verified_at`   timestamp NULL DEFAULT NULL,
    `password`            varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    `rank`                varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
    `avatar`              varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
    `remember_token`      varchar(100) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `created_at`          timestamp NULL DEFAULT NULL,
    `updated_at`          timestamp NULL DEFAULT NULL,
    `stripe_id`           varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `pm_type`             varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `pm_last_four`        varchar(4) COLLATE utf8mb4_unicode_ci            DEFAULT NULL,
    `trial_ends_at`       timestamp NULL DEFAULT NULL,
    `phone`               varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `sellsy_id`           varchar(191) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `organization_id`     bigint(20) UNSIGNED DEFAULT NULL,
    `email_notifications` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `addresses`
    ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`),
  ADD KEY `addresses_partner_id_foreign` (`partner_id`);

ALTER TABLE `agendas`
    ADD PRIMARY KEY (`id`),
  ADD KEY `agendas_space_id_foreign` (`space_id`),
  ADD KEY `agendas_partner_id_foreign` (`partner_id`);

ALTER TABLE `agenda_elements`
    ADD PRIMARY KEY (`id`),
  ADD KEY `agenda_elements_agenda_id_foreign` (`agenda_id`),
  ADD KEY `agenda_elements_estimate_id_foreign` (`estimate_id`),
  ADD KEY `agenda_elements_booking_id_foreign` (`booking_id`),
  ADD KEY `agenda_elements_estimate_requests_id_foreign` (`estimate_request_id`);

ALTER TABLE `articles`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `bookings`
    ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_estimate_id_foreign` (`estimate_id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_organization_id_foreign` (`organization_id`),
  ADD KEY `bookings_er_referent_id_foreign` (`er_referent_id`);

ALTER TABLE `booking_partners`
    ADD PRIMARY KEY (`id`),
  ADD KEY `booking_partners_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_partners_partner_id_foreign` (`partner_id`);

ALTER TABLE `discounts`
    ADD PRIMARY KEY (`id`),
  ADD KEY `discounts_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `discounts_created_by_foreign` (`created_by`);

ALTER TABLE `estimates`
    ADD PRIMARY KEY (`id`),
  ADD KEY `estimates_user_id_foreign` (`user_id`),
  ADD KEY `estimates_billing_address_id_foreign` (`billing_address_id`),
  ADD KEY `estimates_estimate_request_id_foreign` (`estimate_request_id`),
  ADD KEY `estimates_organization_id_foreign` (`organization_id`),
  ADD KEY `estimates_er_referent_id_foreign` (`er_referent_id`);

ALTER TABLE `estimate_activities`
    ADD PRIMARY KEY (`id`),
  ADD KEY `estimate_activities_user_id_foreign` (`user_id`),
  ADD KEY `estimate_activities_estimate_id_foreign` (`estimate_id`);

ALTER TABLE `estimate_elements`
    ADD PRIMARY KEY (`id`),
  ADD KEY `estimate_elements_estimate_id_foreign` (`estimate_id`),
  ADD KEY `estimate_elements_booking_id_foreign` (`booking_id`),
  ADD KEY `estimate_elements_offer_id_foreign` (`offer_id`),
  ADD KEY `estimate_elements_offer_element_id_foreign` (`offer_element_id`),
  ADD KEY `estimate_elements_space_id_foreign` (`space_id`),
  ADD KEY `estimate_elements_partner_id_foreign` (`partner_id`),
  ADD KEY `estimate_elements_agenda_id_foreign` (`agenda_id`);

ALTER TABLE `estimate_files`
    ADD PRIMARY KEY (`id`),
  ADD KEY `estimate_files_estimate_id_foreign` (`estimate_id`),
  ADD KEY `estimate_files_booking_id_foreign` (`booking_id`);

ALTER TABLE `estimate_requests`
    ADD PRIMARY KEY (`id`),
  ADD KEY `estimate_requests_space_id_foreign` (`space_id`);

ALTER TABLE `failed_jobs`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

ALTER TABLE `invoices`
    ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_user_id_foreign` (`user_id`),
  ADD KEY `invoices_partner_id_foreign` (`partner_id`),
  ADD KEY `invoices_booking_id_foreign` (`booking_id`),
  ADD KEY `invoices_address_id_foreign` (`address_id`);

ALTER TABLE `invoice_lines`
    ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_lines_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_lines_partner_id_foreign` (`partner_id`),
  ADD KEY `invoice_lines_offer_element_id_foreign` (`offer_element_id`);

ALTER TABLE `job_offers`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `mails`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `mail_messages`
    ADD PRIMARY KEY (`id`),
  ADD KEY `mail_messages_mail_id_foreign` (`mail_id`),
  ADD KEY `mail_messages_user_id_foreign` (`user_id`);

ALTER TABLE `mail_user`
    ADD PRIMARY KEY (`id`),
  ADD KEY `mail_user_user_id_foreign` (`user_id`),
  ADD KEY `mail_user_mail_id_foreign` (`mail_id`);

ALTER TABLE `media`
    ADD PRIMARY KEY (`id`),
  ADD KEY `media_partner_id_foreign` (`partner_id`),
  ADD KEY `media_space_id_foreign` (`space_id`),
  ADD KEY `media_space_group_id_foreign` (`space_group_id`),
  ADD KEY `media_page_id_foreign` (`page_id`);

ALTER TABLE `notifications`
    ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

ALTER TABLE `offers`
    ADD PRIMARY KEY (`id`),
  ADD KEY `offers_space_group_id_foreign` (`space_group_id`),
  ADD KEY `offers_partner_id_foreign` (`partner_id`);

ALTER TABLE `offer_elements`
    ADD PRIMARY KEY (`id`),
  ADD KEY `offer_elements_offer_id_foreign` (`offer_id`),
  ADD KEY `offer_elements_partner_id_foreign` (`partner_id`),
  ADD KEY `offer_elements_agenda_id_foreign` (`agenda_id`);

ALTER TABLE `organizations`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `pages`
    ADD PRIMARY KEY (`id`),
  ADD KEY `pages_parent_id_foreign` (`parent_id`);

ALTER TABLE `partners`
    ADD PRIMARY KEY (`id`),
  ADD KEY `partners_stripe_id_index` (`stripe_id`);

ALTER TABLE `partner_balance_events`
    ADD PRIMARY KEY (`id`),
  ADD KEY `partner_balance_events_partner_id_foreign` (`partner_id`),
  ADD KEY `partner_balance_events_invoice_line_id_foreign` (`invoice_line_id`);

ALTER TABLE `partner_user`
    ADD PRIMARY KEY (`id`),
  ADD KEY `partner_user_user_id_foreign` (`user_id`),
  ADD KEY `partner_user_partner_id_foreign` (`partner_id`);

ALTER TABLE `password_resets`
    ADD KEY `password_resets_email_index` (`email`);

ALTER TABLE `settings`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

ALTER TABLE `spaces`
    ADD PRIMARY KEY (`id`),
  ADD KEY `spaces_space_group_id_foreign` (`space_group_id`);

ALTER TABLE `space_actions`
    ADD PRIMARY KEY (`id`),
  ADD KEY `space_actions_space_id_foreign` (`space_id`),
  ADD KEY `space_actions_user_id_foreign` (`user_id`);

ALTER TABLE `space_groups`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `space_groups_slug_unique` (`slug`),
  ADD KEY `space_groups_partner_id_foreign` (`partner_id`);

ALTER TABLE `space_tag`
    ADD PRIMARY KEY (`id`),
  ADD KEY `space_tag_space_id_foreign` (`space_id`),
  ADD KEY `space_tag_tag_id_foreign` (`tag_id`);

ALTER TABLE `subscriptions`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscriptions_partner_id_stripe_status_index` (`partner_id`,`stripe_status`);

ALTER TABLE `subscription_items`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_items_subscription_id_stripe_price_unique` (`subscription_id`,`stripe_price`),
  ADD UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`);

ALTER TABLE `tags`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_stripe_id_index` (`stripe_id`),
  ADD KEY `users_organization_id_foreign` (`organization_id`);


ALTER TABLE `addresses`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `agendas`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `agenda_elements`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `articles`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `bookings`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `booking_partners`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `discounts`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `estimates`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `estimate_activities`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `estimate_elements`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `estimate_files`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `estimate_requests`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `failed_jobs`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `invoices`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `invoice_lines`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `job_offers`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `mails`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `mail_messages`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `mail_user`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `media`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `offers`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `offer_elements`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `organizations`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `pages`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `partners`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `partner_balance_events`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `partner_user`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `settings`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `spaces`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `space_actions`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `space_groups`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `space_tag`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `subscriptions`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `subscription_items`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tags`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `addresses`
    ADD CONSTRAINT `addresses_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON
DELETE
CASCADE;

ALTER TABLE `agendas`
    ADD CONSTRAINT `agendas_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  ADD CONSTRAINT `agendas_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`);

ALTER TABLE `agenda_elements`
    ADD CONSTRAINT `agenda_elements_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agenda_elements_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON
DELETE
SET NULL,
  ADD CONSTRAINT `agenda_elements_estimate_id_foreign` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON DELETE
SET NULL,
  ADD CONSTRAINT `agenda_elements_estimate_requests_id_foreign` FOREIGN KEY (`estimate_request_id`) REFERENCES `estimate_requests` (`id`) ON DELETE
CASCADE;

ALTER TABLE `bookings`
    ADD CONSTRAINT `bookings_er_referent_id_foreign` FOREIGN KEY (`er_referent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_estimate_id_foreign` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`),
  ADD CONSTRAINT `bookings_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`),
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `booking_partners`
    ADD CONSTRAINT `booking_partners_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_partners_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

ALTER TABLE `discounts`
    ADD CONSTRAINT `discounts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

ALTER TABLE `estimates`
    ADD CONSTRAINT `estimates_billing_address_id_foreign` FOREIGN KEY (`billing_address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `estimates_er_referent_id_foreign` FOREIGN KEY (`er_referent_id`) REFERENCES `users` (`id`) ON
DELETE
SET NULL,
  ADD CONSTRAINT `estimates_estimate_request_id_foreign` FOREIGN KEY (`estimate_request_id`) REFERENCES `estimate_requests` (`id`),
  ADD CONSTRAINT `estimates_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE
SET NULL,
  ADD CONSTRAINT `estimates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE
SET NULL;

ALTER TABLE `estimate_activities`
    ADD CONSTRAINT `estimate_activities_estimate_id_foreign` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estimate_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON
DELETE
SET NULL;

ALTER TABLE `estimate_elements`
    ADD CONSTRAINT `estimate_elements_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`id`),
  ADD CONSTRAINT `estimate_elements_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `estimate_elements_estimate_id_foreign` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON
DELETE
CASCADE,
  ADD CONSTRAINT `estimate_elements_offer_element_id_foreign` FOREIGN KEY (`offer_element_id`) REFERENCES `offer_elements` (`id`) ON DELETE
SET NULL,
  ADD CONSTRAINT `estimate_elements_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE
SET NULL,
  ADD CONSTRAINT `estimate_elements_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE
SET NULL,
  ADD CONSTRAINT `estimate_elements_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE
SET NULL;

ALTER TABLE `estimate_files`
    ADD CONSTRAINT `estimate_files_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `estimate_files_estimate_id_foreign` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON
DELETE
CASCADE;

ALTER TABLE `estimate_requests`
    ADD CONSTRAINT `estimate_requests_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE;

ALTER TABLE `invoices`
    ADD CONSTRAINT `invoices_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `invoices_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `invoices_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `invoice_lines`
    ADD CONSTRAINT `invoice_lines_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_lines_offer_element_id_foreign` FOREIGN KEY (`offer_element_id`) REFERENCES `offer_elements` (`id`),
  ADD CONSTRAINT `invoice_lines_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

ALTER TABLE `mail_messages`
    ADD CONSTRAINT `mail_messages_mail_id_foreign` FOREIGN KEY (`mail_id`) REFERENCES `mails` (`id`),
  ADD CONSTRAINT `mail_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `mail_user`
    ADD CONSTRAINT `mail_user_mail_id_foreign` FOREIGN KEY (`mail_id`) REFERENCES `mails` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mail_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `media`
    ADD CONSTRAINT `media_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`),
  ADD CONSTRAINT `media_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  ADD CONSTRAINT `media_space_group_id_foreign` FOREIGN KEY (`space_group_id`) REFERENCES `space_groups` (`id`),
  ADD CONSTRAINT `media_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`);

ALTER TABLE `offers`
    ADD CONSTRAINT `offers_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offers_space_group_id_foreign` FOREIGN KEY (`space_group_id`) REFERENCES `space_groups` (`id`) ON
DELETE
CASCADE;

ALTER TABLE `offer_elements`
    ADD CONSTRAINT `offer_elements_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`id`),
  ADD CONSTRAINT `offer_elements_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON
DELETE
CASCADE,
  ADD CONSTRAINT `offer_elements_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE
CASCADE;

ALTER TABLE `pages`
    ADD CONSTRAINT `pages_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL;

ALTER TABLE `partner_balance_events`
    ADD CONSTRAINT `partner_balance_events_invoice_line_id_foreign` FOREIGN KEY (`invoice_line_id`) REFERENCES `invoice_lines` (`id`),
  ADD CONSTRAINT `partner_balance_events_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

ALTER TABLE `partner_user`
    ADD CONSTRAINT `partner_user_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `partner_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON
DELETE
CASCADE;

ALTER TABLE `spaces`
    ADD CONSTRAINT `spaces_space_group_id_foreign` FOREIGN KEY (`space_group_id`) REFERENCES `space_groups` (`id`) ON DELETE CASCADE;

ALTER TABLE `space_actions`
    ADD CONSTRAINT `space_actions_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `space_actions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON
DELETE
SET NULL;

ALTER TABLE `space_groups`
    ADD CONSTRAINT `space_groups_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

ALTER TABLE `space_tag`
    ADD CONSTRAINT `space_tag_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `space_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON
DELETE
CASCADE;

ALTER TABLE `users`
    ADD CONSTRAINT `users_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
