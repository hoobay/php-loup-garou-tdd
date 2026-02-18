<?php
// tests/Players/PlayerCollectionTest.php
declare(strict_types=1);

namespace Tests\Players;

use PHPUnit\Framework\TestCase;
use App\Players\Player;
use App\Players\PlayerCollection;
use App\Roles\Villageois;
use App\Roles\LoupGarou;

class PlayerCollectionTest extends TestCase
{
    public function testCollectionCanBeCreatedEmpty(): void
    {
        $collection = new PlayerCollection();
        
        $this->assertCount(0, $collection);
        $this->assertEquals(0, $collection->count());
    }

    public function testPlayerCanBeAddedToCollection(): void
    {
        $collection = new PlayerCollection();
        $player = new Player('Alice', new Villageois());
        
        $collection->add($player);
        
        $this->assertCount(1, $collection);
        $this->assertTrue($collection->has($player));
    }

    public function testPlayerCanBeRemovedFromCollection(): void
    {
        $collection = new PlayerCollection();
        $player = new Player('Bob', new Villageois());
        
        $collection->add($player);
        $collection->remove($player);
        
        $this->assertCount(0, $collection);
        $this->assertFalse($collection->has($player));
    }

    public function testCollectionCanBeCreatedFromArray(): void
    {
        $players = [
            new Player('Alice', new Villageois()),
            new Player('Bob', new LoupGarou()),
        ];
        
        $collection = new PlayerCollection($players);
        
        $this->assertCount(2, $collection);
    }

    public function testCanGetAlivePlayers(): void
    {
        $collection = new PlayerCollection();
        $alive = new Player('Alice', new Villageois());
        $dead = new Player('Bob', new LoupGarou());
        $dead->kill();
        
        $collection->add($alive);
        $collection->add($dead);
        
        $alivePlayers = $collection->getAlive();
        
        $this->assertCount(1, $alivePlayers);
        $this->assertTrue($alivePlayers->has($alive));
        $this->assertFalse($alivePlayers->has($dead));
    }

    public function testCanGetDeadPlayers(): void
    {
        $collection = new PlayerCollection();
        $alive = new Player('Alice', new Villageois());
        $dead = new Player('Bob', new LoupGarou());
        $dead->kill();
        
        $collection->add($alive);
        $collection->add($dead);
        
        $deadPlayers = $collection->getDead();
        
        $this->assertCount(1, $deadPlayers);
        $this->assertTrue($deadPlayers->has($dead));
    }

    public function testCanGetPlayersByRole(): void
    {
        $collection = new PlayerCollection();
        $villageois = new Player('Alice', new Villageois());
        $loup = new Player('Bob', new LoupGarou());
        
        $collection->add($villageois);
        $collection->add($loup);
        
        $loups = $collection->getByRole(LoupGarou::class);
        
        $this->assertCount(1, $loups);
        $this->assertTrue($loups->has($loup));
    }

    public function testCanGetRandomPlayer(): void
    {
        $collection = new PlayerCollection();
        $player1 = new Player('Alice', new Villageois());
        $player2 = new Player('Bob', new Villageois());
        
        $collection->add($player1);
        $collection->add($player2);
        
        $random = $collection->getRandom();
        
        $this->assertInstanceOf(Player::class, $random);
        $this->assertTrue($random === $player1 || $random === $player2);
    }

    public function testCannotGetRandomPlayerFromEmptyCollection(): void
    {
        $this->expectException(\RuntimeException::class);
        
        $collection = new PlayerCollection();
        $collection->getRandom();
    }

    public function testCollectionIsIterable(): void
    {
        $collection = new PlayerCollection();
        $collection->add(new Player('Alice', new Villageois()));
        $collection->add(new Player('Bob', new LoupGarou()));
        
        $count = 0;
        foreach ($collection as $player) {
            $this->assertInstanceOf(Player::class, $player);
            $count++;
        }
        
        $this->assertEquals(2, $count);
    }

    public function testCanFindPlayerByName(): void
    {
        $collection = new PlayerCollection();
        $alice = new Player('Alice', new Villageois());
        $collection->add($alice);
        
        $found = $collection->findByName('Alice');
        $notFound = $collection->findByName('Inconnu');
        
        $this->assertSame($alice, $found);
        $this->assertNull($notFound);
    }
}