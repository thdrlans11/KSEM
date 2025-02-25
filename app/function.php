<?php
function isAdminCheck()
{
    return auth('admin')->check() ? true : false;
}

// check Url
if (!function_exists('checkUrl')) {    
    function checkUrl(): string
    {
        $uri = str_replace('//www.', '//', request()->getUri());

        if (strpos($uri, config('site.common.api.url')) !== false) {
            return 'api';
        }

        if (strpos($uri, config('site.common.admin.url')) !== false) {
            return 'admin';
        }
        return 'web';
    }
}

// set list seq (paging 있을때)
if (!function_exists('setListSeq')) {
    function setListSeq(object $data)
    {
        $count = 0;
        $total = $data->total();
        $perPage = $data->perPage();
        $currentPage = $data->currentPage();

        // seq 라는 순번 필드를 추가
        $data->getCollection()->transform(function ($data) use ($total, $perPage, $currentPage, &$count) {
            $data->seq = ($total - ($perPage * ($currentPage - 1))) - $count;
            $count++;
            return $data;
        });

        return $data;
    }
}

function excelEntity($array = [])
{
    // 특수문자 때문에
    foreach ($array as $item) {
        $newRow[] = html_entity_decode($item);
    }

    return $newRow ?? [];
}

// D-day
if (!function_exists('DDay')) {
    function DDay($target)
    {
        if( $target == 'event' ){
            $date = config('site.common.info.eventDay');
        }else if( $target == 'abstract' ){
            $date = '2025-03-31';
        }else if( $target == 'earlyRegistration' ){
            $date = '2025-03-14';
        }else if( $target == 'lastRegistration' ){
            $date = '2025-04-30';
        }
        
        $date = explode('-', $date);

        $currentDate = \Carbon\Carbon::now();
        $targetDate = \Carbon\Carbon::create($date[0], $date[1], $date[2]);

        $daysUntilTarget = $currentDate->diffInDays($targetDate);

        if ($daysUntilTarget > 0) {
            return "D-" . $daysUntilTarget;
        }

        if ($daysUntilTarget == 0) {
            return "D-day";
        }

        return 'END';
    }
}

if (!function_exists('wiseuConnection')) {
    function wiseuConnection()
    {
        $host = env('DB_HOST_WISEU');
        $port = env('DB_PORT_WISEU', '1433');
        $dbname = env('DB_DATABASE_WISEU');
        $username = env('DB_USERNAME_WISEU');
        $password = env('DB_PASSWORD_WISEU');

        try {
            $conn = new \PDO(
                "dblib:host={$host}:{$port};dbname={$dbname};TrustServerCertificate=True",
                $username,
                $password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::SQLSRV_ATTR_ENCODING => \PDO::SQLSRV_ENCODING_UTF8
                ]
            );

            return $conn;
        } catch (\PDOException $e) {
            // Log or handle the connection error
            throw $e;
        }
    }
}
?>