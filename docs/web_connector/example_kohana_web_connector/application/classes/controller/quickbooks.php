<?php defined('SYSPATH') or die('No direct script access.');

/**
 * QuickBooks Kohana Integration Example
 * 
 * A simple controller to present data using the qbdata model
 * 
 * @author Jayson Lindsley <jay.lindsley@gmail.com>
 * 
 */

class Controller_Quickbooks extends Controller_Website {

	public function action_index() {
		$this->template->title = __("Quickbooks Management Portal");
		$this->template->content = View::factory('directory/yourview')
				->bind('metrics',$metrics)
				->bind('logs',$logstoday);

		//init the qbdata model
		$qbdata = ORM::factory('qbdata');
		//get the metrics from it
		$metrics = $qbdata->GetQueueBreakdown();
	}

	public function action_errors() {
		$this->template->title = __("Quickbooks Errors");
		$this->template->content = View::factory('directory/yourview/errors')
				->bind('errors', $errors);

		//init the qbdata model
		$qbdata = ORM::factory('qbdata');
		//call the method to get errors
		$errors = $qbdata->GetErrors();
	}

	public function action_help() {
		$this->template->title = __("Help and Documentation");
		$this->template->content = View::factory('directory/yourview/help');
		//make this page the target of qwc help link
	}

	public function action_qwc() {
		//This will deliver a download of the configuration file directly to the clients
		$QBAPI =  Kohana::find_file('classes','controller/qbapi/qwc');
		require_once $QBAPI;
	}
}
