<?php

namespace App\Controllers;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Controller\BaseController;
use PDO;
use App\Core\Utils\HttpClient\Client;

class CountryController extends BaseController
{
    public function getCountries(Request $request, Response $response)
    {
        $db = $this->app->get('database');
        $countries = [];
        $data = [];
        $page = $request->get('page') ?:  1;
        $limit = $request->get('limit') ?: -1;
        if ($limit > 0){

            $offset = intval($limit) * (intval($page) - 1);
            $data["page"] = $page;
            $data["limit"] = $limit;
        }
        $count = $db->query("SELECT count(*) FROM countries")->fetchColumn();
        $data["total"] =$count;
        $db = $this->app->get('database');
        if(intval($limit) <  0){
            $sql = "SELECT * from countries";
        }else{
            $numberOfPages = abs(ceil($count/$limit));
            $data["totalPages"] =$numberOfPages;
            $sql = sprintf("SELECT * from countries LIMIT %d, %d", $offset, $limit);
        }
        $sth = $db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        if($result !== false && !empty($result)){
            $countries = $result;
        }
        $data["values"] = $countries;
        return $response->json($data);
    }

    public function getCountry(Request $request, Response $response, $country_id)
    {
        $db = $this->app->get('database');
        $countries = [];
        $data = [];
       
        $sql = sprintf("SELECT * from countries where id =  %d", $country_id);

        $sth = $db->prepare($sql);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_OBJ);
        if($result !== false && !empty($result)){
            $countries = $result;
        }else{
            return $response->json(['error'=> true, 'message' => 'Not Found'], 404);
        }
        $data = $countries;
        return $response->json($data);
    }
    public function index(Request $request, Response $response)
    {
        // die(var_dump($_SESSION));
        $db = $this->app->get('database');
        $countries = [];
        $page = $request->get('page') ?:  1;
        $limit = $request->get('limit') ?: 50;
        $offset = intval($limit) * (intval($page) - 1);
        try{
            $client = new \GuzzleHttp\Client();
            $responseData = $client->request('GET', 'http://localhost/api/v1/countries');
            $data = json_decode($responseData->getBody());
            $count = count($data->values);
            $numberOfPages = ceil($count/$limit);
            $result = array_slice($data->values, $offset, $limit);
            if($result !== false && !empty($result)){
                $countries = $result;
            }
            $data = [
                "page" => intval($page),
                "totalPages" => intval($numberOfPages),
                "total" => $count,
                "limit" => $limit,
                "offset" => $offset + 1,
                // "values" => $countries,
                "next_page" =>   $page != $numberOfPages ? sprintf('/dashboard?page=%d',$page + 1) : null,
                "previous_page" => $page > 1 ? sprintf('/dashboard?page=%d',$page - 1) : null,
            ];
        } catch (\Exception $e){
            $message = "An error occured while trying to get countries";
           return $response->redirect('/dashboard?error='.true. '&message='.$message);
        }
       
        return $response->render('dashboard/countries/index.php', compact('countries', 'data'));
    }

    public function show(Request $request, Response $response, $country_id)
    {
        $db = $this->app->get('database');
        $states = [];
        $page = $request->get('page') ?:  1;
        $limit = $request->get('limit') ?: 50;
        $offset = intval($limit) * (intval($page) - 1);
        try{
            $client = new \GuzzleHttp\Client();
            $responseData = $client->request('GET', 'http://localhost/api/v1/countries/'.$country_id.'/states');
            $data = json_decode($responseData->getBody());
            $count = count($data->values);
            $numberOfPages = ceil($count/$limit);
            $result = array_slice($data->values, $offset, $limit);
            if($result !== false || !empty($result)){
                $states = $result;
            }
            $data = [
                "page" => $page,
                "totalPages" => $numberOfPages,
                "total" => $count,
                'offset' => $offset + 1,
                "limit" => $limit,
                "values" => $states,
                "next_page" =>   $$page != $numberOfPages ?  sprintf('/dashboard/countries/%d/states?page=%d',$country_id, $page + 1) : null,
                "previous_page" => $page > 1  ? sprintf('/dashboard/countries/%d/states?page=%d',$country_id, $page - 1) : null,
            ];
            
        } catch (\Exception $e){
            $message = "An error occured while trying to get countries";
            return $response->redirect('/dashboard?error='.true. '&message='.$message);
        }
        return $response->render('dashboard/states/index.php', compact('states','data'));
    }
    public function getStates(Request $request, Response $response, $country_id)
    {
        $db = $this->app->get('database');
        $states = [];
        $page = $request->get('page') ?:  1;
        $limit = $request->get('limit') ?: -1;
        if ($limit > 0){

            $offset = intval($limit) * (intval($page) - 1);
            $data["page"] = $page;
            $data["limit"] = $limit;
        }
        $offset = intval($limit) * (intval($page) - 1);
        $db = $this->app->get('database');
        $count = $db->query(sprintf("SELECT count(*) FROM states where country_id = %d", $country_id))->fetchColumn();
        $numberOfPages = ceil($count/$limit);
        if(intval($limit) <  0){
            $sql = "SELECT * from states";
        }else{
            $numberOfPages = abs(ceil($count/$limit));
            $data["totalPages"] =$numberOfPages;
            $sql = sprintf("SELECT * from states LIMIT %d, %d where country_id = %d", $offset, $limit, $country_id);
        }
        $sth = $db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        if($result !== false || !empty($result)){
            $states = $result;
        }
        $data['values'] = $states;
        return $response->json($data);
    }
}
