<?php

namespace App\Controllers;

use App\Helpers\ExceptionHandlerHelper;
use App\Exceptions\NoDataFoundException;
use App\Exceptions\ParamsMissingException;
use App\Exceptions\ShortlinkExistsException;
use CodeIgniter\RESTful\ResourceController;
use Exception;

/**
 * Class URLController
 * 
 * This class is responsible for handling the URL-related operations in the application.
 * It extends the CodeIgniter RESTful ResourceController class.
 */
class URLController extends ResourceController
{
    private $URLModel;

    /**
     * URLController constructor.
     * 
     * Initializes the URLModel instance.
     */
    public function __construct()
    {
        $this->URLModel = model("App\Models\URLModel");
    }

    /**
     * Get all shortlinks.
     * 
     * Retrieves all the shortlinks from the URLModel and returns them as JSON response.
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface The JSON response containing the shortlinks.
     */
    public function getAllShortlinks()
    {
        try {
            $data = $this->URLModel->getAllShortlinks();
            return $this->response->setJSON($data);
        } catch (NoDataFoundException | Exception $e) {
            return ExceptionHandlerHelper::handleException($e);
        }
    }

    /**
     * Get a shortlink by slug.
     * 
     * Retrieves a shortlink from the URLModel based on the provided slug and returns it as JSON response.
     * 
     * @param string $slug The slug of the shortlink.
     * @return \CodeIgniter\HTTP\ResponseInterface The JSON response containing the shortlink.
     */
    public function getShortlink($slug)
    {
        try {
            $data = $this->URLModel->getShortlink($slug);
            return $this->response->setJSON($data);
        } catch (NoDataFoundException | Exception $e) {
            return ExceptionHandlerHelper::handleException($e);
        }
    }

    /**
     * Create a shortlink.
     * 
     * Creates a new shortlink based on the provided long URL and slug.
     * If the long URL or slug is missing, it throws a ParamsMissingException.
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface The JSON response indicating the success or failure of the operation.
     */
    public function createShortlink()
    {
        $shortlink = [];

        try {
            $shortlink["longUrl"] = $this->request->getPost("longUrl");
            $shortlink["slug"] = $this->request->getPost("slug");
            if (empty($shortlink["longUrl"]) || empty($shortlink["slug"])) {
                throw new ParamsMissingException();
            } else {
                $this->URLModel->createShortlink($shortlink);
                $this->response->setStatusCode(201);
                $response = [
                    "response" => "success",
                    "msg" => "Shortlink created successfully",
                ];
                return $this->response->setJSON($response);
            }
        } catch (ShortlinkExistsException | ParamsMissingException | Exception $e) {
            return ExceptionHandlerHelper::handleException($e);
        }
    }

    /**
     * Update a shortlink.
     * 
     * Updates an existing shortlink with the provided new long URL and slug.
     * If any of the new long URL, new slug, or old slug is missing, it throws a ParamsMissingException.
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface The JSON response indicating the success or failure of the operation.
     */
    public function updateShortlink()
    {
        $shortlink = [];
        
        try {
            $shortlink["newLongUrl"] = $this->request->getVar("newLongUrl");
            $shortlink["newSlug"] = $this->request->getVar("newSlug");
            $shortlink["oldSlug"] = $this->request->getVar("oldSlug");

            if (
                empty($shortlink["newLongUrl"]) ||
                empty($shortlink["newSlug"]) ||
                empty($shortlink["oldSlug"])
            ) {
                throw new ParamsMissingException();
            } else {
                $this->URLModel->updateShortlink($shortlink);
                $this->response->setStatusCode(200);
                $response = [
                    "response" => "success",
                    "msg" => "Shortlink successfully updated",
                ];
                return $this->response->setJSON($response);
            }
        } catch (ShortlinkExistsException | ParamsMissingException | Exception $e) {
            return ExceptionHandlerHelper::handleException($e);
        }
    }

    /**
     * Delete a shortlink.
     * 
     * Deletes an existing shortlink based on the provided slug.
     * 
     * @param string $slug The slug of the shortlink to be deleted.
     * @return \CodeIgniter\HTTP\ResponseInterface The JSON response indicating the success or failure of the operation.
     */
    public function deleteShortlink($slug)
    {
        try {
            $this->URLModel->deleteShortlink($slug);
            $this->response->setStatusCode(200);
            $response = [
                "response" => "success",
                "msg" => "Shortlink deleted successfully",
            ];
            return $this->response->setJSON($response);
        } catch (ShortlinkExistsException | ParamsMissingException | Exception $e) {
            return ExceptionHandlerHelper::handleException($e);
        }
    }
}
