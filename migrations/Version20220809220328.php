<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220809220328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creacion de tablas iniciales';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA colegio');
        $this->addSql('CREATE SEQUENCE colegio.docentes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE colegio.estudiantes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE colegio.materias_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE colegio.docentes (id INT NOT NULL, identificacion TEXT NOT NULL, nombres TEXT NOT NULL, apellidos TEXT NOT NULL, direccion TEXT DEFAULT NULL, barrio TEXT DEFAULT NULL, telefono TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE colegio.estudiantes (id INT NOT NULL, identificacion TEXT NOT NULL, nombres TEXT NOT NULL, apellidos TEXT NOT NULL, direccion TEXT NOT NULL, barrio TEXT NOT NULL, telefono TEXT NOT NULL, fecha_nacimiento DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE colegio.materias (id INT NOT NULL, docente_id INT NOT NULL, nombre TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D6680FE894E27525 ON colegio.materias (docente_id)');
        $this->addSql('ALTER TABLE colegio.materias ADD CONSTRAINT FK_D6680FE894E27525 FOREIGN KEY (docente_id) REFERENCES colegio.docentes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE colegio.docentes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE colegio.estudiantes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE colegio.materias_id_seq CASCADE');
        $this->addSql('ALTER TABLE colegio.materias DROP CONSTRAINT FK_D6680FE894E27525');
        $this->addSql('DROP TABLE colegio.docentes');
        $this->addSql('DROP TABLE colegio.estudiantes');
        $this->addSql('DROP TABLE colegio.materias');
    }
}
