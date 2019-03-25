<?php

namespace App\Controllers;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Controller\BaseController;
use PDO;

class CountryController extends BaseController
{
    public function index(Request $request, Response $response)
    {
        $db = $this->app->get('database');
        $countries = [];
        $page = $request->get('page') ?:  1;
        $limit = $request->get('limit') ?: 50;
        $offset = intval($limit) * (intval($page) - 1);
        $db = $this->app->get('database');
        $count = $db->query("SELECT count(*) FROM countries")->fetchColumn();
        $numberOfPages = ceil($count/$limit);
        $sth = $db->prepare(sprintf("SELECT * from countries LIMIT %d, %d", $offset, $limit));
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        if($result !== false || !empty($result)){
            $countries = $result;
        }
        // $data = [
        //     "page" => $page,
        //     "totalPages" => $numberOfPages,
        //     "total" => $count,
        //     "limit" => $limit,
        //     "values" => $countries,
        // ];
        // return $response->json($data);
        return $response->render('dashboard/countries/index.php', compact($countries));
    }

    public function show(Request $request, Response $response, $country_id)
    {
        $db = $this->app->get('database');
        $countries = [];
        $page = $request->get('page') ?:  1;
        $limit = $request->get('limit') ?: 50;
        $offset = intval($limit) * (intval($page) - 1);
        $db = $this->app->get('database');
        $count = $db->query("SELECT count(*) FROM states")->fetchColumn();
        $numberOfPages = ceil($count/$limit);
        $sth = $db->prepare(sprintf("SELECT * from states LIMIT %d, %d where country_id = %s", $offset, $limit, $country_id));
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        if($result !== false || !empty($result)){
            $countries = $result;
        }
        $data = [
            "page" => $page,
            "totalPages" => $numberOfPages,
            "total" => $count,
            "limit" => $limit,
            "values" => $countries,
        ];
        return $response->json($data);
    }
}
