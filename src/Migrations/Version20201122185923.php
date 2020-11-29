<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201122185923 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED493CABC6AF');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED4999DED506');
        $this->addSql('DROP INDEX IDX_C751ED493CABC6AF ON attribution');
        $this->addSql('DROP INDEX IDX_C751ED4999DED506 ON attribution');
        $this->addSql('ALTER TABLE attribution ADD client_id INT NOT NULL, ADD ordinateur_id INT NOT NULL, DROP id_client_id, DROP id_ordinateur_id');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED4919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED49828317CA FOREIGN KEY (ordinateur_id) REFERENCES ordinateur (id)');
        $this->addSql('CREATE INDEX IDX_C751ED4919EB6921 ON attribution (client_id)');
        $this->addSql('CREATE INDEX IDX_C751ED49828317CA ON attribution (ordinateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED4919EB6921');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED49828317CA');
        $this->addSql('DROP INDEX IDX_C751ED4919EB6921 ON attribution');
        $this->addSql('DROP INDEX IDX_C751ED49828317CA ON attribution');
        $this->addSql('ALTER TABLE attribution ADD id_client_id INT NOT NULL, ADD id_ordinateur_id INT NOT NULL, DROP client_id, DROP ordinateur_id');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED493CABC6AF FOREIGN KEY (id_ordinateur_id) REFERENCES ordinateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED4999DED506 FOREIGN KEY (id_client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C751ED493CABC6AF ON attribution (id_ordinateur_id)');
        $this->addSql('CREATE INDEX IDX_C751ED4999DED506 ON attribution (id_client_id)');
    }
}
