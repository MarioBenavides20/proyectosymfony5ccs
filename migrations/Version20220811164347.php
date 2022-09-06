<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220811164347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // ingreso de datos mediante migrate a la tabla paises en postgres
        $this->addSql("INSERT INTO libros.paises(id, pais) VALUES (nextval('libros.paises_id_seq'), 'Panama');");
        $this->addSql("INSERT INTO libros.paises(id, pais) VALUES (nextval('libros.paises_id_seq'), 'Mexico');");
        $this->addSql("INSERT INTO libros.paises(id, pais) VALUES (nextval('libros.paises_id_seq'), 'Rep dominicana');");
        $this->addSql("INSERT INTO libros.paises(id, pais) VALUES (nextval('libros.paises_id_seq'), 'Cuba');");
        $this->addSql("INSERT INTO libros.paises(id, pais) VALUES (nextval('libros.paises_id_seq'), 'Texas');");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE libros.autores DROP CONSTRAINT FK_626077AC604D5C6');
        $this->addSql('ALTER TABLE libros.editoriales DROP CONSTRAINT FK_2F84E337C604D5C6');
        $this->addSql('ALTER TABLE libros.libros DROP CONSTRAINT FK_EC629D60BAF1A24D');
        $this->addSql('ALTER TABLE libros.libros DROP CONSTRAINT FK_EC629D6014D45BBE');
        $this->addSql('ALTER TABLE colegio.materias DROP CONSTRAINT FK_D6680FE894E27525');
        $this->addSql('ALTER TABLE colegio.notas DROP CONSTRAINT FK_9F205382B54DBBCB');
        $this->addSql('ALTER TABLE colegio.notas DROP CONSTRAINT FK_9F20538259590C39');
        $this->addSql('DROP TABLE libros.autores');
        $this->addSql('DROP TABLE colegio.docentes');
        $this->addSql('DROP TABLE libros.editoriales');
        $this->addSql('DROP TABLE colegio.estudiantes');
        $this->addSql('DROP TABLE libros.libros');
        $this->addSql('DROP TABLE colegio.materias');
        $this->addSql('DROP TABLE colegio.notas');
        $this->addSql('DROP TABLE libros.paises');
    }
}
