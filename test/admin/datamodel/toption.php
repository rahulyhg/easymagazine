<?php

/*
    Copyright (C) 2009-2012  Fabio Mattei <burattino@gmail.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class OptionTests extends UnitTestCase {

    private $db;

    public function __construct() {
        $this->db = new DbCreator();
        $this->db->connect();
    }

    function setUp() {
        $this->db->dropSchema();
        $this->db->createSchema();
        $this->db->populateSchema();
    }

    public function tearDown() {
        $this->db->dropSchema();
    }

    function testfindById() {
        $opt = Option::findById(1);
        $this->assertPattern('(commandSandBox)', $opt->getName());
    }

}

$test = new OptionTests();
$test->run(new HtmlReporter());

?>
