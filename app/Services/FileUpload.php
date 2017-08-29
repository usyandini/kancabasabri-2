<?php 

namespace App\Services;

class FileUpload
{
	public function upload($request, $routeName)
	{
		$destinationPath = $name = '';
		if (isset($request)) {
			$file = $request;
			$extension = $file->getClientOriginalExtension();
			$destinationPath = $this->getDestinationPath( $routeName );		
			//$name = $routeName.'-user:'.\Auth::user()->id.'-'.strtotime(date('Y-m-d H:i:s')).'.'.$extension;
			//$name = $routeName.'-'.strtotime(date('Y-m-d H:i:s')).'.'.$extension;
			$name = $file->getClientOriginalName();
			$request->move( $destinationPath, $name );
		}
		//else $name = null;
		return $name;
	}	

	public function base64Upload($inputs)
	{
		$results = '';
		if(isset($inputs)){
			$results = [
				'name' => $inputs->getClientOriginalName(),
				'size' => $inputs->getClientSize(),
				'type' => $inputs->getClientMimeType(),
				'data' => base64_encode(file_get_contents($inputs))
			];
		}
		return $results;
	}

	public function multipleBase64Upload($inputs)
	{
		$results = [];
		if (isset($inputs)) {
			foreach ($inputs as $value) {
				$results[] = [
				'file_name' => $value->getClientOriginalName(), 
				'file' => base64_encode(file_get_contents($value)), 
				'created_at' => \Carbon\Carbon::now(), 
				'updated_at' => \Carbon\Carbon::now()];
			}
		}

		return $results;
	}

	public function multipleUpload( $request, $routeName )
	{
		$destinationPath = $name = $names = '';
		if (isset($request)) {
			$number=1;
			foreach ($request as $value) {
				$extension = $value->getClientOriginalExtension();
				$destinationPath = $this->getDestinationPath( $routeName );		
				$name = $routeName.'-'.strtotime(date('Y-m-d H:i:s')).'-'.$number++.'.'.$extension;
				$value->move( $destinationPath, $name );
				$names .= '||'.$name;
			}
		}
		else $names = null;
		return ltrim($names, '||');
	}

	public static function getDestinationPath( $routeName )
	{
		switch ($routeName) {
			case 'transaksi':
				$path = public_path().'/file/transaksi/'; 
				break;
			case 'tariktunai':
				$path = public_path().'/file/tariktunai/'; 
				break;
			case 'penyesuaian':
				$path = public_path().'/file/penyesuaian/'; 
				break;
		}

		return $path;
	}
}