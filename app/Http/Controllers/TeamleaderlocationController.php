<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamleaderlocationController extends Controller
{
    public function view()
    {    	 
        $url = "http://172.16.20.48/cm/contractors-api.php";
        $json = file_get_contents($url);
        $obj = json_decode($json);
        $data  = '';
        $seq=0;
        foreach($obj as $contractor){
        	$seq++;
        	$data .= '<tr class="odd gradeX">
        	<td>
									<input type="checkbox" class="checkboxes" value="1"/>
								</td>

        		<td>'.$seq.'</td>
				<td>'.$contractor->contractor.'</td>
				<td>'.$contractor->location.'</td>
				
        	</tr>';           
        }
      
        return view('location.view',compact('data'));;
    }
}
