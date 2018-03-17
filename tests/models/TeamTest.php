<?hh

class TeamTest extends nscctfTest {

  public function testAll(): void {
    $all = HH\Asio\join(Team::genAllTeams());
    $this->assertEquals(1, count($all));

    $t = $all[0];
    $this->assertEquals(1, $t->getId());
    $this->assertTrue($t->getActive());
    $this->assertFalse($t->getAdmin());
    $this->assertFalse($t->getProtected());
    $this->assertTrue($t->getVisible());
    $this->assertEquals('name', $t->getName());
    $this->assertEquals('password_hash', $t->getPasswordHash());
    $this->assertEquals(10, $t->getPoints());
    $this->assertEquals('2015-04-26 12:14:20', $t->getLastScore());
    $this->assertEquals('logo', $t->getLogo());
    $this->assertEquals('2015-04-26 12:14:20', $t->getCreatedTs());
    
    // live sync tests
    $this->assertTrue(HH\Asio\join(Team::genSetLiveSyncPassword($t->getId(), 'nscctf', 'test', 'testing')));
    $this->assertTrue(HH\Asio\join(Team::genLiveSyncExists($t->getId(), 'nscctf')));
    $t = HH\Asio\join(Team::genTeamFromLiveSyncKey(HH\Asio\join(Team::genGetLiveSyncKey($t->getId(), 'nscctf'))));
    $this->assertEquals(1, $t->getId());
    $this->assertTrue($t->getActive());
    $this->assertFalse($t->getAdmin());
    $this->assertFalse($t->getProtected());
    $this->assertTrue($t->getVisible());
    $this->assertEquals('name', $t->getName());
    $this->assertEquals('password_hash', $t->getPasswordHash());
    $this->assertEquals(10, $t->getPoints());
    $this->assertEquals('2015-04-26 12:14:20', $t->getLastScore());
    $this->assertEquals('logo', $t->getLogo());
    $this->assertEquals('2015-04-26 12:14:20', $t->getCreatedTs());
  }
}
