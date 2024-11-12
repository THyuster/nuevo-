<?php

namespace App\Http\Controllers\modulo_nomina\Blacklist;

use App\Data\Dtos\Convocatorias\BlanckListDTOs\BlacklistRequestCreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\NominaRequest\NominaBlacklistCreateRequest;
use App\Utils\TransfersData\ModuloNomina\Blacklist\IServiceNominaBlacklist;
use Illuminate\Http\Request;

class nomina_blacklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected IServiceNominaBlacklist $_serviceBlacklist;
    public function __construct(IServiceNominaBlacklist $iServiceNominaBlacklist)
    {
        $this->_serviceBlacklist = $iServiceNominaBlacklist;
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NominaBlacklistCreateRequest $nominaBlacklistCreateRequest)
    {
        $blacklistDTO = new BlacklistRequestCreateDTO($nominaBlacklistCreateRequest->all());
        return $this->_serviceBlacklist->create($blacklistDTO);
        // return $blacklistDTO->toArray();
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $datatableResponseDTO = $this->_serviceBlacklist->get();
        return response()->json($datatableResponseDTO);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NominaBlacklistCreateRequest $nominaBlacklistUpdateRequest, string $id)
    {
        $blacklistDTO = new BlacklistRequestCreateDTO($nominaBlacklistUpdateRequest->all());
        return $this->_serviceBlacklist->update($id, $blacklistDTO);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->_serviceBlacklist->delete($id);
    }
}
