<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220809221307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cargue de datos requeridos';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO colegio.docentes(
            id,  identificacion, nombres, apellidos, direccion, barrio, telefono)
        VALUES (nextval('colegio.docentes_id_seq'), '12990996', 'Jaime', 
                'Perez', 'Calle 12', 'Tamasagra', '7236530');");
        $this->addSql("INSERT INTO colegio.docentes(
            id,  identificacion, nombres, apellidos, direccion, barrio, telefono)
        VALUES (nextval('colegio.docentes_id_seq'), '95336996', 'Luis', 
                'Muñoz', 'Calle 10', 'Centro', '7312636');");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE colegio.materias DROP CONSTRAINT FK_D6680FE894E27525');
        $this->addSql('ALTER TABLE colegio.notas DROP CONSTRAINT FK_9F205382B54DBBCB');
        $this->addSql('ALTER TABLE colegio.notas DROP CONSTRAINT FK_9F20538259590C39');
        $this->addSql('DROP TABLE colegio.docentes');
        $this->addSql('DROP TABLE colegio.estudiantes');
        $this->addSql('DROP TABLE colegio.materias');
        $this->addSql('DROP TABLE colegio.notas');
    }
}
