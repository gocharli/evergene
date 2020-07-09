<?php

defined('BASEPATH') or exit('No direct script access allowed');
// include APPPATH.'third_party/azure/vendor/autoload.php';
// use WindowsAzure\Common\ServicesBuilder;
// use WindowsAzure\Common\ServiceException;
class Results extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

	}
	public function create_file()
	{
		$detailId=1;
		$testId=1;
		$testName='name';
		$date=date('Ymdhis');
		$order_number=$date.'_'.$detailId;
		$data = 'MSH|^~\&|TDL Messaging|TDL|Receiving App|Receiving facility|'.$date.'||ORU^R01|'.$order_number.'|T|2.3.1|||AL|||||
PID|||PATIENTNUM||PATIENT^TEST^^^||198202160000|M|||^^^^|||||||||||||||||||
PV1|||GRAHAM^Graham Hogan|||||||||||||||||||||||||||||||||||||||||
ORC|RE|'.$detailId.'|0018M998899||CM||||'.$date.'|||||||||||
OBR|1|'.$detailId.'|0018M998899|'.$testId.'^'.$testName.'^WinPath||201804040000|201804040000|||||||201804040000||^||||||'.$date.'||TDL|I||||||||||||||||||||';
		$filename= $order_number.'.hl7';
		if ( ! write_file('./uploads/requests/'.$filename, $data))
		{
			echo 'Unable to write the file';
		}
		else
		{
			echo 'File written!';
		}
	}
	public function index(){
	  
		$this->load->helper('directory');
		$connectionString = 'DefaultEndpointsProtocol=https;AccountName=tdlevergene;AccountKey=Qm/b6vopuvykxUgeTbca635Os632itfGhtVHyoRgWFw+Kkycp65ea7RAbMCPgrX3hPDK9nWPMFXTmbtDG7i+Ww==';
		$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
		try {
			// List blobs.
			$blob_list = $blobRestProxy->listBlobs("results");
			$blobs = $blob_list->getBlobs();

			foreach($blobs as $blob)
			{
				$getBlobResult = $blobRestProxy->getBlob("results", $blob->getName());
				file_put_contents('./uploads/results/'.$blob->getName(), $getBlobResult->getContentStream());
			}
		} catch(ServiceException $e){
		}
		$found=array();
        $ids=array();
        $orginal_ref=array();
		$order_details_res = $this->db->query('select * from order_details WHERE detailStatus="Inprogress"')->result();
		foreach ($order_details_res as $res)
		{
			$found[]=strtoupper($res->ref_2);
            $ids[]=$res->detailId;
            $orginal_ref[]=$res->ref_2;
		}

		$map = directory_map('./uploads/results');
		foreach ($map as $m)
		{
			$mm=explode('_',$m);
			if(isset($mm[1]))
			{
				$oid=str_replace('.hl7','',$mm[1]);
                $srch_res=array_search($oid, $found);
                
                
				if($srch_res > -1)
				{ 
					$order_detail_id=$ids[$srch_res];
					$order_details = $this->db->query('select * from order_details WHERE detailId='.$order_detail_id.' and detailStatus="Inprogress"')->row();
					if($order_details) {
						$file_name = $m;
						if (file_exists('./uploads/results/' . $file_name)) {
							$string = file_get_contents('./uploads/results/'.$file_name);

							$results = $this->read_hl7($string);

							foreach ($results as $row) {
								if ($row[0] == 'OBR') {
									if(isset($row[4]))
									{
										$test=(isset($row[4][0]) ? $row[4][0]:'');
										$testname=(isset($row[4][1]) ? $row[4][1]:'');
										$lab=(isset($row[4][3]) ? $row[4][3]:'');
									}
									$ins=array();
									$ins['detailId']=$order_details->detailId;
									$ins['orderId']=$order_details->orderId;
									$ins['testId']=$order_details->testId;
									$ins['userId']=$order_details->userId;
									$ins['resultTest']=$test;
									$ins['resultTestName']=$testname;
									$ins['resultLabDepartment']=$lab;
									$ins['resultValue']='';
									$ins['resultUnit']='';
									$ins['resultRange']='';
									$ins['resultFlag']='';
									$ins['resType']='OBR';
									$ins['createdAt']=current_datetime();
									$this->db->insert('results',$ins);
								}
								if ($row[0] == 'OBX') {

									if(isset($row[3]))
									{
										$test=(isset($row[3][0]) ? $row[3][0]:'');
										$testname=(isset($row[3][1]) ? $row[3][1]:'');
										$lab=(isset($row[3][3]) ? $row[3][3]:'');
									}
									$resultValue=(isset($row[5]) ? $row[5]:'');
									$resultUnit=(isset($row[6]) ? $row[6]:'');
									$resultRange=(isset($row[7]) ? $row[7]:'');
									$resultFlag=(isset($row[8]) ? $row[8]:'');

									$ins=array();
									$ins['detailId']=$order_details->detailId;
									$ins['orderId']=$order_details->orderId;
									$ins['testId']=$order_details->testId;
									$ins['userId']=$order_details->userId;
									$ins['resultTest']=$test;
									$ins['resultTestName']=$testname;
									$ins['resultLabDepartment']=$lab;
									$ins['resultValue']=$resultValue;
									$ins['resultUnit']=$resultUnit;
									$ins['resultRange']=$resultRange;
									$ins['resultFlag']=$resultFlag;
									$ins['resType']='OBX';
									$ins['createdAt']=current_datetime();
									$this->db->insert('results',$ins);

								}
                                if ($row[0] == 'NTE') 
                                {
                                    
									$setId=(isset($row[1]) ? $row[1]:'');
									$comment=(isset($row[2]) ? $row[2]:'');
								
									$ins=array();
									$ins['detailId']=$order_details->detailId;
									$ins['orderId']=$order_details->orderId;
									$ins['testId']=$order_details->testId;
									$ins['userId']=$order_details->userId;
									$ins['nte_setId']=$setId;
									$ins['nte_comment']=$comment;
									$ins['resType']='NTE';
									$ins['createdAt']=current_datetime();
									$this->db->insert('results',$ins);
                                    
                                }   
							}
							$upd=array();
							$upd['detailStatus']='Recieved';
							$this->db->update('order_details',$upd,array('detailId'=>$order_details->detailId));
						}
					}
				}

			}
		}

	}
	function read_hl7($string)
	{
		$segs = explode("\n",$string);

		$out = array();

		//get delimiting characters
		if (substr($segs[0],0,3) != 'MSH') {
			return $out;
			exit;
		}

		$delbarpos = strpos($segs[0],'|',4);  //looks for the closing bar of the delimiting characters
		$delchar = substr($segs[0],4,($delbarpos - 4));
		define('FLD_SEP', substr($delchar,0,1));
		define('SFLD_SEP', substr($delchar,1,1));
		define('REP_SEP', substr($delchar,2,1));
		define('ESC_CHAR', substr($delchar,3,1));
		foreach($segs as $fseg) {
			//$out[$segname]
			$arr=array();
			$segments = explode('|',$fseg);
			$segname = $segments[0];
			$i = 0;
			foreach ($segments as $seg) {
				if (count(explode(FLD_SEP,$seg))>1) {
					$j=0;
					$sf = explode(FLD_SEP,$seg);
					foreach($sf as $f) {
						$arr[$i][$j] = $f;
						$j++;
					}
				} else {
					$arr[$i] = $seg;
				}
				$i++;
			}
			$out[]=$arr;
		}
		//define('PT_NAME',$out['PID'][5][0],true);
		return $out;
	}

}
