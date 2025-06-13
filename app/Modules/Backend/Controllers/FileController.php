<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Modules\Backend\Models\FileModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

class FileController extends BackendController
{
    protected $fileModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->fileModel = new FileModel();
    }

    public function index($file_id)
    {
        $file = $this->fileModel->find($file_id);
        if(!empty($file))
        {
            $filePath = WRITEPATH . 'uploads/' . $file['document_id'] . '/' . $file['file_name'];
            if(!file_exists($filePath))
            {
                return $this->response->setStatusCode('404')->setJSON(['error' => 'File not found']);
            }
            return $this->response
                ->setContentType($file['file_mime'])
                ->setBody(file_get_contents($filePath));
        }
        else
        {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'File not found']);
        }
    }

    public function save()
    {
        if($this->request->isAJAX())
        {
            $status = false;
            $message= 'Gagal mengunggah file.';
            $errors = [
                'validations' => null
            ];
            $post   = $this->request->getVar();
            $fileData = array(
                'file_id' => null,
                'name' => null,
                'url' => null,
                'deleteUrl' => null,
                'key' => null,
                'downloadUrl' => null
            );

            $classification = [
                'kak' => 'Kerangka Acuan Kerja (KAK)',
                'form_permintaan' => 'Form Permintaan',
                'sk_kpa' => 'Surat Keputusan KPA',
                'surat_tugas' => 'Surat Tugas',
                'mon_kegiatan' => 'SPJ Kegiatan',
                'dok_kegiatan' => 'Dokumen Kegiatan',
                'adm_kegiatan' => 'Dokumen Keuangan'
            ]; 

            if(array_key_exists($post['classification'], $classification))
            {
                $this->validation->setRule(
                    $post['classification'], 
                    $classification[$post['classification']], 
                    'uploaded['.$post['classification'].']|max_size['.$post['classification'].',5000]|mime_in['.$post['classification'].',application/pdf]|ext_in['.$post['classification'].',pdf]');
                    
                if($this->validation->withRequest($this->request)->run()) {
                    $file = $this->request->getFile($post['classification']);


                    if (($file->isValid() && ! $file->hasMoved())) 
                    {
                        $dir = WRITEPATH . 'uploads/'.$post['document_id'];
                        if(!is_dir($dir)) @mkdir($dir, 0755, true);

                        $fileName = $file->getRandomName();
                        $fileMime = $file->getMimeType();
                        $fileSize = $file->getSize();
                        $fileType = $file->getExtension();
                        $fullPath = $dir . '/' . $fileName;

                        if (!$file->move($dir, $fileName)) 
                        {
                            $message = $file->getErrorString();
                        }
                        else
                        {
                            switch ($post['action']) {
                                case 'edit':
                                    $fileId = $post['file_id'];
                                    $status = $this->fileModel->update($post['file_id'], [
                                        'file_name' => $fileName,
                                        'file_mime' => $fileMime,
                                        'file_size' => $fileSize,
                                        'file_type' => $fileType,
                                        'file_classification' => $post['classification'],
                                        'deleted_at' => null
                                    ]);
                                    $message = ($status) ? 'File berhasil diunggah.' : 'Gagal mengunggah file.';
                                    break;
                                
                                default:
                                    $fileId = Uuid::uuid7()->toString();
                                    $status = $this->fileModel->insert([
                                        'file_id' => $fileId,
                                        'document_id' => $post['document_id'],
                                        'file_name' => $fileName,
                                        'file_mime' => $fileMime,
                                        'file_size' => $fileSize,
                                        'file_type' => $fileType,
                                        'file_classification' => $post['classification']
                                    ], false);
                                    $message = ($status) ? 'File berhasil diunggah.' : 'Gagal mengunggah file.';
                                    break;
                            }
                            if($status) {
                                $fileData = array(
                                    'file_id' => $fileId,
                                    'name' => $fileName,
                                    'url' => base_url('blackhole/file/'.$fileId),
                                    'deleteUrl' => base_url('blackhole/file/hapus'),
                                    'key' => $fileId,
                                    'downloadUrl' => base_url('blackhole/file/'.$fileId)
                                );
                            }
                        }
                    }
                    else
                    {
                        $errors['validations'] = $file->getErrorString();
                    }
                }
                else
                {
                    $errors['validations'] = implode('<br/>', $this->validation->getErrors());
                }
            } 
            else
            {
                $errors['validations'] = 'Klasifikasi/jenis file tidak diketahui.';
            }
            $result = array(
                'token' => csrf_hash(),
                'status'=> $status,
                // 'isError' => ($status ? null : true),
                'message' => $message,
                'file' => $fileData,
                'errors' => $errors['validations']
            );
            return $this->response->setStatusCode(200)->setJSON($result);
        }
        else
        {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed.']);
        }
    }
    
    public function delete()
    {
        if ($this->request->isAJAX()) {

            $status     = false;
            $errors     = [
                'validations' => ''
            ];
            $message    = '';
            $post       = $this->request->getVar();

            $this->validation->setRules([
                'key' => [
                    'label' => 'ID File',
                    'rules' => 'required|uuid7'
                ]
            ]);

            if($this->validation->run($post) == true)
            {
                $status = $this->fileModel->delete($post['key']);
                $message= ($status) ? 'File dihapus.' : 'File gagal dihapus.';
                if ($status) {
                    logging('file', 'File ' . $post['key'] . ' dihapus oleh ' . self::$udata['user_name']);
                }
            }
            else
            {
                $errors['validations'] = $this->validation->getError('key');
            }

            $data = array(
                'status' => $status, 
                'message' => $message, 
                'errors' => $errors['validations'],
                'token' => csrf_hash()
            );
            return $this->response->setStatusCode(200)->setJSON($data);
        }
        else
        {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed.']);
        }
    }
}