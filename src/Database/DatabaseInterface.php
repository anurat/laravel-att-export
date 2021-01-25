<?php

namespace Anurat\AttExport\Database;

interface DatabaseInterface
{
    public function connect();
    public function close();
}
