<?php

namespace App\Http\Controllers;
use \App\Model\TmLokasi;
use \App\Model\LogSensor;
use \App\Model\TmStatus;
use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public $_data=null;
    private $_status = null;
    private $_message = null;
    private $_errorMessage = null;


    public function __construct()
    {
        //
    }

    public function output() {
        $output = [
            'status' => $this->_status,
            'message' => $this->_message,
            'errorMessage' => $this->_errorMessage,
            'data' => $this->_data,
        ];
        return $output;
    }

    private function errorContent() {
        $this->_status = 205;
        $this->_message = 'Error Content Not Found';
        $this->_errorMessage = "Error Content Not Found";
        return $this->output();
    }

    public function get_lokasi($id)
    {
        $data = TmLokasi::find($id);
        if(empty($data)){
            $dataResult = $this->errorContent();
        }else{
            $this->_status = 200;
            $this->_message = 'Berhasil Ambil Lokasi';
            $this->_data = $data;
            $dataResult = $this->output();

        }
        return view('api',compact('dataResult'));
    }
    public function get_status()
    {
        $data = TmStatus::all();
        $hasil = array();
        if(empty($data)){
            $dataResult = $this->errorContent();
        }else{
            foreach($data as $item){
                $hasil[] = $item;
            }

            $this->_status = 200;
            $this->_message = 'Berhasil Ambil Status';
            $this->_data = $hasil;
            $dataResult = $this->output();

        }
        return view('api',compact('dataResult'));
    }
    public function get_lokasi_status()
    {
        $dataLokasi = TmLokasi::all();
        $hasil = array();
        
        if(empty($dataLokasi)){
            $dataResult = $this->errorContent();
        }else{
            foreach($dataLokasi as $item){
                
                $dataSensor = LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$item->id)->orderBy('waktu','desc')->first();
                $maxSensor =  LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$item->id)->where('ketinggian_air', LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$item->id)->max('ketinggian_air'))->first();
                $minSensor =  LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$item->id)->where('ketinggian_air', LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$item->id)->min('ketinggian_air'))->first();
                $avg = LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$item->id)->avg('ketinggian_air');
                $hasil[] = array(
                    'id_lokasi' => $item->id,
                    'nama' => $item->nama_lokasi,
                    'now_tinggi' => $dataSensor->ketinggian_air,
                    'now_time' => date("H-i", strtotime($dataSensor->waktu)),
                    'max_tinggi' => $maxSensor->ketinggian_air,
                    'max_time' => date("H-i", strtotime($maxSensor->waktu)),
                    'min_tinggi' => $minSensor->ketinggian_air,
                    'min_time' => date("H-i", strtotime($minSensor->waktu)),
                    'avg' => number_format($avg, 2),
                    'id_status' => $dataSensor->id_status,
                    'status' => $dataSensor->status->status,

                );
            }

            $this->_status = 200;
            $this->_message = 'Berhasil Ambil Lokasi Status';
            $this->_data = $hasil;
            $dataResult = $this->output();

        }
        return view('api',compact('dataResult'));
    }

    public function get_lokasi_status_by_id($id)
    {
        $dataLokasi = TmLokasi::find($id);
        $hasil = array();
        
        if(empty($dataLokasi)){
            $dataResult = $this->errorContent();
        }else{  
            $dataSensor = LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$dataLokasi->id)->orderBy('waktu','desc')->first();
            $maxSensor =  LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$dataLokasi->id)->where('ketinggian_air', LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$dataLokasi->id)->max('ketinggian_air'))->first();
            $minSensor =  LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$dataLokasi->id)->where('ketinggian_air', LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$dataLokasi->id)->min('ketinggian_air'))->first();
            $avg = LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$dataLokasi->id)->avg('ketinggian_air');
            $hasil[] = array(
                'id_lokasi' => $dataLokasi->id,
                'nama' => $dataLokasi->nama_lokasi,
                'now_tinggi' => $dataSensor->ketinggian_air,
                'now_time' => date("H-i", strtotime($dataSensor->waktu)),
                'max_tinggi' => $maxSensor->ketinggian_air,
                'max_time' => date("H-i", strtotime($maxSensor->waktu)),
                'min_tinggi' => $minSensor->ketinggian_air,
                'min_time' => date("H-i", strtotime($minSensor->waktu)),
                'avg' => number_format($avg, 2),
                'id_status' => $dataSensor->id_status,
                'status' => $dataSensor->status->status,

            );

            $this->_status = 200;
            $this->_message = 'Berhasil Ambil Statis Lokasi By Id';
            $this->_data = $hasil;
            $dataResult = $this->output();

        }
        return view('api',compact('dataResult'));
    }
    public function get_grafik($id)
    {
        $dataSensor = LogSensor::whereDate('waktu', date("Y-m-d"))->where('id_lokasi',$id)->get()->groupBy(function($date) {
                return Carbon::parse($date->waktu)->format('H');
            });
        $hasil = array();
        
        if(empty($dataSensor)){
            $dataResult = $this->errorContent();
        }else{
            foreach($dataSensor as $key => $item){
                $hasil[] = array(
                    'id_lokasi' => $item[0]->id_lokasi,
                    'jam' => $key,
                    'ketinggian_air' => number_format($item[0]->ketinggian_air,0)
                );
            }
            sort($hasil);
            $this->_status = 200;
            $this->_message = 'Berhasil Ambil Lokasi Status';
            $this->_data = $hasil;
            $dataResult = $this->output();

        }
        return view('api',compact('dataResult'));
    }
}
