<?php
namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlankDataTable extends DataTable
{
	public $routeResource;
	public $actions = true;
	public $modal = true;
	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query)
	{
		$datatable = datatables()->eloquent($query);
		if($this->actions) {
			$datatable->addColumn('action', function($row){
				return $this->getActions($row);
			});
		}
		$datatable->editColumn('created_at', function ($row) {
			return date("d-m-Y H:i:s", strtotime($row->created_at));
		})->editColumn('updated_at', function ($row) {
			return date("d-m-Y H:i:s", strtotime($row->updated_at));
		})->editColumn('is_active', function ($row){
			if ($row->is_active == 1) {
				return '<span class="font-size-12 badge-soft-success badge bg-success rounded-pill text-white">'.__("Yes").'</span>';
			}elseif ($row->is_active == 0){
				return '<span class="font-size-12 badge-soft-success badge bg-danger rounded-pill text-white">'.__("No").'</span>';
			}
		})->rawColumns(["is_active", "action"]);
		return $datatable;
	}

	/**
	 * Optional method if you want to use html builder.
	 *
	 * @return \Yajra\DataTables\Html\Builder
	 */
	public function html()
	{	
		return $this->builder()
			->parameters($this->getBuilderParameters())
			->setTableId($this->routeResource.'-table')
			->addTableClass('nowrap')
			->columns($this->getColumns())
			->minifiedAjax()
			->responsive('true')
			->language(asset('js/datatables/datatables_Spanish.json'))
			//->orderBy(1)
			/*->buttons(
				Button::make('excel')->text('<i class="fa fa-file-excel"></i> '.__('Excel'))
				
			)*/;
	}

	public function getBuilderParameters()
	{
		return [
			'pageLength' => 15,
			/*'lengthMenu'=> [
				[15,30,45, -1 ],
				[ 15, 30, 45, "Todos" ]
			],*/
			'dom' => 'fBrtip',
			'serverSide' => true,
			'processing' => true,
			'responsive' => true,
			'stateSave' => true,
			'columnDefs' => [
				['responsivePriority' => 1, 'targets' => 1] 
			],
			'buttons' => [
				['extend' => 'colvis', 'text' => 'Mostrar/Ocultar Columnas', 'className' => 'btn btn-primary']
			],
			'drawCallback' => 'function() { customizeDatatable('.($this->modal ? 1 : 0).') }'
		];
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	protected function getColumns()
	{
		return $this->actions ? [
			Column::computed('action', __('action'))
			->responsivePriority(2)
			->exportable(false)
			->printable(false)
			->width(200)
			->addClass('text-center'),
		] : [];
	}

	public function getActions($row)
	{
		$result = '';
		/*if(auth()->user()->hasPermissions($this->routeResource.".show")) {
			$result .= '<a href="'.route($this->routeResource.".show", $row->id).'">
				<button type="button" class="btn btn-default" title='.__('show').'>
					<i class="fa fa-eye text-success actions_icon"></i>
				</button>
			</a>';
		}*/
		if(auth()->user()->hasPermissions($this->routeResource.".edit")) {
			if ($this->modal) {
				$params = base64_encode(json_encode([
					"entity_source" => $this->routeResource,
					"entity" => $this->routeResource,
					"saveAditionals" => 'reloadDatatable',
					"id" => $row->id
				]));
				$result .= '
					<button type="button" class="btn btn-default" title="'.__('edit').'" onclick="showQuickAddModal(\''.$params.'\')">
						<i class="mdi mdi-pencil icon-edit font-size-18"></i>
					</button>';
			} else {
				$result .= '
				<a href="'.route($this->routeResource.".edit", $row->id).'">
					<button type="button" class="btn btn-default" title='.__('edit').'>
						<i class="mdi mdi-pencil icon-edit font-size-18"></i>
					</button>
				</a>';
			}
		}
		if(auth()->user()->hasPermissions($this->routeResource.".destroy")) {
			$result .= '
				<button type="button" class="btn btn-default" title="'.__('delete').'" onclick="showDeleteModal(\''.$this->routeResource.'\', '.$row->id.')">
					<i class="mdi mdi-delete icon-delete font-size-18"></i>
				</button>';
		}

		return $result;
	}

	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename()
	{
		return $this->routeResource.'_'.date('YmdHis');
	}
}