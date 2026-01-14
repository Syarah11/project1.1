CREATE TABLE `Beritas`(
    `id_berita` CHAR(36) NOT NULL,
    `id_user` CHAR(36) NOT NULL,
    `judul` VARCHAR(255) NOT NULL,
    `slug` TEXT NOT NULL,
    `deskripsi` TEXT NOT NULL,
    `thumbnail` VARCHAR(255) NOT NULL,
    `status` ENUM('') NOT NULL,
    `view_count` INT(11) NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `update_at` TIMESTAMP NOT NULL,
    PRIMARY KEY(`id_berita`)
);
CREATE TABLE `Users`(
    `id_user` CHAR(36) NOT NULL,
    `nama` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` TEXT NOT NULL,
    `role` ENUM('') NOT NULL,
    `thumbnail` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `update_at` TIMESTAMP NOT NULL,
    PRIMARY KEY(`id_user`)
);
CREATE TABLE `gambar_ejurnals`(
    `id_gambar_ejurnal` CHAR(36) NOT NULL,
    `id_ejurnal` CHAR(36) NOT NULL,
    `id_user` CHAR(36) NOT NULL,
    `gambar` TEXT NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `update_at` TIMESTAMP NOT NULL,
    PRIMARY KEY(`id_gambar_ejurnal`)
);
CREATE TABLE `ejurnals`(
    `id_ejurnal` CHAR(36) NOT NULL,
    `id_user` CHAR(36) NOT NULL,
    `judul` VARCHAR(255) NOT NULL,
    `deskripsi` TEXT NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `update_at` TIMESTAMP NOT NULL,
    PRIMARY KEY(`id_ejurnal`)
);
CREATE TABLE `iklans`(
    `id_iklan` CHAR(36) NOT NULL,
    `id_user` CHAR(36) NOT NULL,
    `nama` VARCHAR(100) NOT NULL,
    `thumbnail` VARCHAR(255) NOT NULL,
    `status` ENUM('') NOT NULL,
    `link` VARCHAR(255) NOT NULL,
    `posisis` ENUM('') NOT NULL,
    `urutan` INT(11) NULL,
    `created_at` TIMESTAMP NOT NULL,
    `update_at` TIMESTAMP NOT NULL,
    PRIMARY KEY(`id_iklan`)
);
CREATE TABLE `Kategoris`(
    `id_kategori` CHAR(36) NOT NULL,
    `nama_kategori` VARCHAR(255) NOT NULL,
    `slug` TEXT NOT NULL,
    `deskripsi` TEXT NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `update_at` TIMESTAMP NOT NULL,
    PRIMARY KEY(`id_kategori`)
);
CREATE TABLE `tags`(
    `id_tag` CHAR(36) NOT NULL,
    `nama_tag` VARCHAR(100) NOT NULL,
    `created_by` CHAR(36) NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `create_at` TIMESTAMP NOT NULL,
    `update_at` TIMESTAMP NOT NULL,
    PRIMARY KEY(`id_tag`)
);
CREATE TABLE `berita_kategoris`(
    `id_berita_kategori` CHAR(36) NOT NULL,
    `id_berita` CHAR(36) NOT NULL,
    `id_kategori` CHAR(36) NOT NULL,
    PRIMARY KEY(`id_berita_kategori`)
);
CREATE TABLE `berita_tag`(
    `id_berita_tag` CHAR(36) NOT NULL,
    `id_berita` CHAR(36) NOT NULL,
    `id_tag` CHAR(36) NOT NULL,
    PRIMARY KEY(`id_berita_tag`)
);