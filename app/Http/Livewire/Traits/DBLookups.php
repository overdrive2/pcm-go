<?php

namespace App\Http\Livewire\Traits;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Models\Department;
use App\Models\Doctype;
use App\Models\Mnyear;
use App\Models\Site;
use App\Models\Stmas;
use App\Models\StmasGroup;
use App\Models\StmasPlan;
use App\Models\UserSite;
use App\Models\Vendor;
use Illuminate\Support\Facades\Storage;

trait DBLookups
{
    use WithCachedRows;

    public $search = [
        'dept_kw'    => '',
        'doctype_kw' => '',
        'group_kw'   => '',
        'vendor_kw'  => '',
        'stkmas_kw'  => '',
        'dept_id'    => '',
        'inpln'      => 'Y',
        'y'          => '',
    ];

    public $year;

    public function getSiteRowsProperty()
    {
        $sites = UserSite::where('usercode', auth()->user()->usercode)->pluck('site');
        return Site::whereIn('id', $sites)->get();
    }

    public function getGroupRowsProperty()
    {
        return $this->cache(function(){
            return
                StmasGroup::whereIn('id', auth()->user()->group_ids)
                    ->when($this->search['group_kw'], function($query, $kw) {
                        return $query->where('flname', 'like', '%'.$kw.'%');
                    })
                    ->orderBy('id', 'asc')
                    ->get();
        });
    }

    public function getDeptRowsProperty()
    {
        return $this->cache(function () {
            $query = Department::selectRaw("dept_id, dept_name")
                ->where('enable', 'Y')
                ->orderBy('dept_name', 'asc')
                ->when($this->search['dept_kw'],
                    function($query, $kw){
                        return $query->whereRaw("(dept_id = '".$kw."')or(dept_name like '%".$kw."%')");
                });

            return $query->get();
        });

    }

    public function getDoctypeRowsProperty()
    {
        return $this->cache(function () {
            $query = Doctype::selectRaw("id, docname")
                ->orderBy('docname', 'asc')
                ->when($this->search['doctype_kw'],
                    function($query, $kw){
                        return $query->whereRaw("docname like '%".$kw."%'");
                });

            return $query->get();
        });

    }

    public function getMoneyRowsProperty()
    {
        return $this->cache(function () {
            $query = Mnyear::selectRaw("id, mntype.mntype, y")
                ->join("mntype", 'mnyears.mntypes_id', 'mntype.m_id')
                ->where('enable', 'Y')->where('y', '>=', Date('Y')-1)
                ->orderBy('y', 'desc')->orderBy('mntype.mntype', 'asc');

            return $query->get();
        });
    }

    public function getVendorRowsProperty()
    {
        return $this->cache(function () {
            $query = Vendor::selectRaw("id, prenam, supnam, flg")
                ->where('flg', 'Y')
                ->when($this->search['vendor_kw'],
                    function($query, $kw){
                        return $query->whereRaw("supnam like '%".$kw."%'");
                })->orderBy('supnam', 'asc');

            return $query->get();
        });

    }

    public function getStmasRowsProperty()
    {
        if($this->search['inpln'] == 'Y'){
            return $this->cache(function () {
                $query = StmasPlan::selectRaw("stkplan.id, stmas.stkcod, stkplan.stkdesc as stkdes, stkplan.prc as unitpr, stkplan.pqty")
                    ->join('stmas', 'stmas.stkcod', 'stkplan.stkcode')
                    ->where('stmas.status', 'A')
                    ->where('stkplan.dept', $this->search['dept_id'])
                    ->where('stkplan.pqty', '>', 0)
                    ->where('stkplan.pamt', '>', 0)
                    ->when($this->search['stkmas_kw'],
                        function($query, $kw){
                            return  $query->whereRaw("((stkdes like '%".$kw."%')or(stkcod like '".$kw."%'))");
                        });
                return $query->paginate(15);
            });
        }else{
            return $this->cache(function () {
                $query = Stmas::where('status', 'A')
                ->when($this->search['stkmas_kw'],
                    function($query, $kw){
                        return $query->whereRaw("((stkdes like '%".$kw."%')or(stkcod like '".$kw."%'))");
                    });

                return $query->orderBy('stkcod', 'asc')->orderBy('stkdes', 'asc')->paginate(15);
            });
        }
    }

    public function getIconRowsProperty()
    {
        return Storage::disk('local')->allFiles('public/icons');
    }
}
