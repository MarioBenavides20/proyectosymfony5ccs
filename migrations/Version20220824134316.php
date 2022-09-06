<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824134316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA agricola');
        $this->addSql('CREATE SEQUENCE agricola.cabcompras_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE agricola.detcompras_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE agricola.nocompra_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE agricola.productos_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE agricola.proveedores_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE agricola.cabcompras (id INT NOT NULL, proveedor_id INT DEFAULT NULL, fecha DATE DEFAULT NULL, numero TEXT DEFAULT NULL, estado INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6978C1FCB305D73 ON agricola.cabcompras (proveedor_id)');
        $this->addSql('CREATE TABLE agricola.detcompras (id INT NOT NULL, compra_id INT DEFAULT NULL, producto_id INT NOT NULL, cant INT NOT NULL, vrunidad DOUBLE PRECISION NOT NULL, subtotal DOUBLE PRECISION DEFAULT NULL, iva INT DEFAULT NULL, vriva DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_373FEC6F2E704D7 ON agricola.detcompras (compra_id)');
        $this->addSql('CREATE INDEX IDX_373FEC67645698E ON agricola.detcompras (producto_id)');
        $this->addSql('CREATE TABLE agricola.nocompra (id INT NOT NULL, no_actual TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE agricola.productos (id INT NOT NULL, codigo VARCHAR(100) DEFAULT NULL, nombre VARCHAR(200) DEFAULT NULL, existencia INT DEFAULT NULL, costo DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE agricola.proveedores (id INT NOT NULL, nombre TEXT DEFAULT NULL, nit TEXT DEFAULT NULL, direccion TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE agricola.cabcompras ADD CONSTRAINT FK_6978C1FCB305D73 FOREIGN KEY (proveedor_id) REFERENCES agricola.proveedores (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agricola.detcompras ADD CONSTRAINT FK_373FEC6F2E704D7 FOREIGN KEY (compra_id) REFERENCES agricola.cabcompras (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agricola.detcompras ADD CONSTRAINT FK_373FEC67645698E FOREIGN KEY (producto_id) REFERENCES agricola.productos (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE agricola.cabcompras_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE agricola.detcompras_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE agricola.nocompra_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE agricola.productos_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE agricola.proveedores_id_seq CASCADE');
        $this->addSql('ALTER TABLE libros.autores DROP CONSTRAINT FK_626077AC604D5C6');
        $this->addSql('ALTER TABLE agricola.cabcompras DROP CONSTRAINT FK_6978C1FCB305D73');
        $this->addSql('ALTER TABLE agricola.detcompras DROP CONSTRAINT FK_373FEC6F2E704D7');
        $this->addSql('ALTER TABLE agricola.detcompras DROP CONSTRAINT FK_373FEC67645698E');
        $this->addSql('ALTER TABLE libros.editoriales DROP CONSTRAINT FK_2F84E337C604D5C6');
        $this->addSql('ALTER TABLE libros.libros DROP CONSTRAINT FK_EC629D60BAF1A24D');
        $this->addSql('ALTER TABLE libros.libros DROP CONSTRAINT FK_EC629D6014D45BBE');
        $this->addSql('ALTER TABLE colegio.materias DROP CONSTRAINT FK_D6680FE894E27525');
        $this->addSql('ALTER TABLE colegio.notas DROP CONSTRAINT FK_9F205382B54DBBCB');
        $this->addSql('ALTER TABLE colegio.notas DROP CONSTRAINT FK_9F20538259590C39');
        $this->addSql('DROP TABLE libros.autores');
        $this->addSql('DROP TABLE agricola.cabcompras');
        $this->addSql('DROP TABLE agricola.detcompras');
        $this->addSql('DROP TABLE colegio.docentes');
        $this->addSql('DROP TABLE libros.editoriales');
        $this->addSql('DROP TABLE colegio.estudiantes');
        $this->addSql('DROP TABLE libros.libros');
        $this->addSql('DROP TABLE colegio.materias');
        $this->addSql('DROP TABLE agricola.nocompra');
        $this->addSql('DROP TABLE colegio.notas');
        $this->addSql('DROP TABLE libros.paises');
        $this->addSql('DROP TABLE agricola.productos');
        $this->addSql('DROP TABLE agricola.proveedores');
    }
}
