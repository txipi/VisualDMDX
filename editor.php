    <div class="container">
      <div id="content">
        <br/>
        <!-- tabs -->
        <div class="tabbable">
          <div class="navbar navbar-default">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </div>
              <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                  <li class="active"><a href="#edit" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
                  <li><a href="#import" data-toggle="tab"><span class="glyphicon glyphicon-import"></span> Import</a></li>
                  <li><a href="#export" data-toggle="tab"><span class="glyphicon glyphicon-export"></span> Export</a></li>
                  <li><a href="#preview" data-toggle="tab"><span class="glyphicon glyphicon-film"></span> Preview</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="" data-bind="click: $root.restoreLatest">Project id: <span class="badge" data-bind="text: id"></span></a></li>
                  <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">Versions <b class="caret"></b></a>
                    <ul class="dropdown-menu" id="versionslinks">
                      <!-- li elements added programatically -->
                    </ul>
                  </li>
                  <li><a href="" id="savebutton" class="popover-link" data-toggle="popover" data-placement="right" data-content="Saving" data-bind="click: $root.saveChanges"><span class="glyphicon glyphicon-save"></span> Save</a></li>
                </ul>
              </div><!-- /.nav-collapse -->
            </div><!-- /.container -->
          </div><!-- /.navbar -->
          <div>
            <input class="form-control" data-bind="value: description" placeholder="Type here a description for this experiment" />
            <br/>
          </div>
          <div class="tab-content">
            <div class="tab-pane active" id="edit">
              <div class="col-sm-2">
                <ul class="nav nav-pills nav-stacked">
                  <li class="active"><a href="#parameters" data-toggle="pill"><span class="glyphicon glyphicon-cog"></span> Parameters</a></li>
                  <li><a href="#items" data-toggle="pill"><span class="glyphicon glyphicon-tasks"></span> Items</a></li>
                </ul>
              </div>
              <div class="col-sm-10">
                <div class="pill-content">
                  <div class="pill-pane active" id="parameters">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <ul class="nav nav-pills pull-right">
                          <li class="active"><a href="#parametersinput" data-toggle="pill"><span class="glyphicon glyphicon-log-in"></span> Input</a></li>
                          <li><a href="#parametersoutput" data-toggle="pill"><span class="glyphicon glyphicon-log-out"></span> Output</a></li>
                          <li><a href="#parametersother" data-toggle="pill"><span class="glyphicon glyphicon-filter"></span> Other</a></li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="panel-body">
                        <div class="pill-content">
                          <div class="pill-pane active" id="parametersinput">
                            <div class="well">
                              <form class="form-horizontal" id="formparametersinput">
                                <div class="form-group">
                                  <label class="col-lg-2 control-label">Time limit (ms)<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'t')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <div class="col-lg-10">
                                    <input class="form-control" type="number" min="1" data-bind="value: parameters.timeout">
                                  </div>
                                </div><!-- /time limit -->
                                <div class="form-group">
                                  <label class="control-label col-xs-2">Keyboard<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'id')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <span class="col-xs-8"></span>
                                  <div class="col-xs-2">
                                    <div class="switch switch-2">
                                      <input id="parametersinputkeyboardyes" name="parametersinputkeyboardyes" type="radio" value="true" data-bind="checked: parameters.keyboard">
                                      <label for="parametersinputkeyboardyes"><span class="glyphicon glyphicon-ok"></span></label>
                                      <input id="parametersinputkeyboardno"name="parametersinputkeyboardno" type="radio" value="false" data-bind="checked: parameters.keyboard">
                                      <label for="parametersinputkeyboardno"><span class="glyphicon glyphicon-remove"></span></label>
                                      <span class="slide-button btn btn-success"></span>
                                    </div>
                                  </div>
                                </div><!-- /keyboard -->
                                <div class="form-group">
                                  <label class="control-label col-xs-2">Mouse<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'id')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <span class="col-xs-8"></span>
                                  <div class="col-xs-2">
                                    <div class="switch switch-2">
                                      <input id="parametersinputmouseyes" name="parametersinputmouseyes" type="radio" value="true" data-bind="checked: parameters.mouse">
                                      <label for="parametersinputmouseyes"><span class="glyphicon glyphicon-ok"></span></label>
                                      <input id="parametersinputmouseno" name="parametersinputmouseno" type="radio" value="false" data-bind="checked: parameters.mouse">
                                      <label for="parametersinputmouseno"><span class="glyphicon glyphicon-remove"></span></label>
                                      <span class="slide-button btn btn-success"></span>
                                    </div>
                                  </div>
                                </div><!-- /mouse -->
                                <div class="form-group">
                                  <label class="control-label col-xs-2">PIO 12<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'id')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <span class="col-xs-8"></span>
                                  <div class="col-xs-2">
                                    <div class="switch switch-2">
                                      <input id="parametersinputpio12yes" name="parametersinputpio12yes" type="radio" value="true" data-bind="checked: parameters.PIO12">
                                      <label for="parametersinputpio12yes"><span class="glyphicon glyphicon-ok"></span></label>
                                      <input id="parametersinputpio12no" name="parametersinputpio12no" type="radio" value="false" data-bind="checked: parameters.PIO12">
                                      <label for="parametersinputpio12no"><span class="glyphicon glyphicon-remove"></span></label>
                                      <span class="slide-button btn btn-success"></span>
                                    </div>
                                  </div>
                                </div><!-- /pio12 -->
                                <div class="form-group">
                                  <label class="control-label col-xs-2">Digital VOX<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'id')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <span class="col-xs-8"></span>
                                  <div class="col-xs-2">
                                    <div class="switch switch-2">
                                      <input id="parametersinputdigitalvoxyes" name="parametersinputdigitalvoxyes" type="radio" value="true" data-bind="checked: parameters.digitalvox">
                                      <label for="parametersinputdigitalvoxyes"><span class="glyphicon glyphicon-ok"></span></label>
                                      <input id="parametersinputdigitalvoxno" name="parametersinputdigitalvoxno" type="radio" value="false" data-bind="checked: parameters.digitalvox">
                                      <label for="parametersinputdigitalvoxno"><span class="glyphicon glyphicon-remove"></span></label>
                                      <span class="slide-button btn btn-success"></span>
                                    </div>
                                  </div>
                                </div><!-- /digitalvox -->
                                <div class="form-group">
                                  <label class="control-label col-xs-2">Record vocal<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'id')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <span class="col-xs-8"></span>
                                  <div class="col-xs-2">
                                    <div class="switch switch-2">
                                      <input id="parametersinputrecordvocalyes" name="parametersinputrecordvocalyes" type="radio" value="true" data-bind="checked: parameters.recordvocal">
                                      <label for="parametersinputrecordvocalyes"><span class="glyphicon glyphicon-ok"></span></label>
                                      <input id="parametersinputrecordvocalno" name="parametersinputrecordvocalno" type="radio" value="false" data-bind="checked: parameters.recordvocal">
                                      <label for="parametersinputrecordvocalno"><span class="glyphicon glyphicon-remove"></span></label>
                                      <span class="slide-button btn btn-success"></span>
                                    </div>
                                  </div>
                                </div><!-- /recordvocal -->
                              </form>
                            </div>
                          </div>
                          <div class="pill-pane" id="parametersoutput">
                            <div class="well">
                              <form class="form-horizontal" id="formparametersoutput">
                                <div class="form-group">
                                  <label class="col-lg-2 control-label">Video mode<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'vm')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <div class="col-lg-10">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-2">
                                  </div>
                                  <label class="col-lg-2 control-label">Width</label>
                                  <div class="col-lg-8">
                                    <input class="form-control" type="number" min="640" data-bind="value: parameters.videomode.width">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-2">
                                  </div>
                                  <label class="col-lg-2 control-label">Heigth</label>
                                  <div class="col-lg-8">
                                    <input class="form-control" type="number" min="480" data-bind="value: parameters.videomode.height">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-2">
                                  </div>
                                  <label class="col-lg-2 control-label">Real height</label>
                                  <div class="col-lg-8">
                                    <input class="form-control" type="number" min="480" data-bind="value: parameters.videomode.realheight">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-2">
                                  </div>
                                  <label class="col-lg-2 control-label">Bpp</label>
                                  <div class="col-lg-8">
                                    <input class="form-control" type="number" min="8" data-bind="value: parameters.videomode.bpp">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-2">
                                  </div>
                                  <label class="col-lg-2 control-label">Refresh rate</label>
                                  <div class="col-lg-8">
                                    <input class="form-control" type="number" min="0" data-bind="value: parameters.videomode.hz">
                                  </div>
                                </div><!-- /videomode -->
                                <div class="form-group">
                                  <label class="control-label col-xs-2">Feedback<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'nfb')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <div class="col-xs-10">
                                    <select class="form-control" data-bind="options: ['None', 'Outcome', 'Outcome and RT'], optionsText: function(place) { return place; }, optionsValue: function(place) { return place.toLowerCase(); }, value: parameters.feedback"></select>
                                  </div>
                                </div><!-- /feedback -->
                                <div class="form-group">
                                  <label class="col-lg-2 control-label">Frame duration (ticks)<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'dfd')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <div class="col-lg-10">
                                    <input class="form-control" type="number" min="1" data-bind="value: parameters.frameduration">
                                  </div>
                                </div><!-- /frameduration -->
                                <div class="form-group">
                                  <label class="col-lg-2 control-label">Delay (ticks)<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'d')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <div class="col-lg-10">
                                    <input class="form-control" type="number" min="1" data-bind="value: parameters.delay">
                                  </div>
                                </div><!-- /delay -->
                                <div class="form-group">
                                  <label class="control-label col-xs-2">Continous run<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'cr')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <span class="col-xs-8"></span>
                                  <div class="col-xs-2">
                                    <div class="switch switch-2">
                                      <input id="parametersoutputcontinuosrunyes" name="parametersoutputcontinuosrunyes" type="radio" value="true" data-bind="checked: parameters.continuosrun">
                                      <label for="parametersoutputcontinuosrunyes"><span class="glyphicon glyphicon-ok"></span></label>
                                      <input id="parametersoutputcontinuosrunno" name="parametersoutputcontinuosrunno" type="radio" value="false" data-bind="checked: parameters.continuosrun">
                                      <label for="parametersoutputcontinuosrunno"><span class="glyphicon glyphicon-remove"></span></label>
                                      <span class="slide-button btn btn-success"></span>
                                    </div>
                                  </div>
                                </div><!-- /continuosrun -->   
                                <div class="form-group">
                                  <label class="col-lg-2 control-label">Default font color<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'dwc')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <div class="col-lg-10 text-right">
                                    <input class="pick-a-color input-color" type="text" data-bind="value: parameters.color" name="parametersoutputcolor">
                                  </div>
                                </div><!-- /color -->                          
                                <div class="form-group">
                                  <label class="col-lg-2 control-label">Default background color<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'dbc')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <div class="col-lg-10 text-right">
                                    <input class="pick-a-color input-color" type="text" data-bind="value: parameters.bgcolor" name="parametersoutputbgcolor">
                                  </div>
                                </div><!-- /bgcolor -->                          
                                <div class="form-group">
                                  <label class="col-lg-2 control-label">Font size<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'dfs')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <div class="col-lg-10">
                                    <input class="form-control" type="number" min="1" data-bind="value: parameters.fontsize">
                                  </div>
                                </div><!-- /fontsize -->
                              </form>
                            </div>
                          </div>
                          <div class="pill-pane" id="parametersother">
                            <div class="well">
                              <form class="form-horizontal" id="formparametersother">
                                <div class="form-group">
                                  <label class="control-label col-xs-2">Output to ASCII<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'azk')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <span class="col-xs-8"></span>
                                  <div class="col-xs-2">
                                    <div class="switch switch-2">
                                      <input id="parametersotheroutputasciiyes" name="parametersotheroutputasciiyes" type="radio" value="true" data-bind="checked: parameters.outputascii">
                                      <label for="parametersotheroutputasciiyes"><span class="glyphicon glyphicon-ok"></span></label>
                                      <input id="parametersotheroutputasciino" name="parametersotheroutputasciino" type="radio" value="false" data-bind="checked: parameters.outputascii">
                                      <label for="parametersotheroutputasciino"><span class="glyphicon glyphicon-remove"></span></label>
                                      <span class="slide-button btn btn-success"></span>
                                    </div>
                                  </div>
                                </div><!-- /outputascii -->    
                                <div class="form-group">
                                  <label class="control-label col-xs-2">Record clock on time<br/><a href="#" data-bind="click: $root.showHelp.bind($data,'rcot')" class="glyphicon glyphicon-question-sign"></a></label>
                                  <span class="col-xs-8"></span>
                                  <div class="col-xs-2">
                                    <div class="switch switch-2">
                                      <input id="parametersotherrecordclockontimeyes" name="parametersotherrecordclockontimeyes" type="radio" value="true" data-bind="checked: parameters.recordclockontime">
                                      <label for="parametersotherrecordclockontimeyes"><span class="glyphicon glyphicon-ok"></span></label>
                                      <input id="parametersotherrecordclockontimeno" name="parametersotherrecordclockontimeno" type="radio" value="false" data-bind="checked: parameters.recordclockontime">
                                      <label for="parametersotherrecordclockontimeno"><span class="glyphicon glyphicon-remove"></span></label>
                                      <span class="slide-button btn btn-success"></span>
                                    </div>
                                  </div>
                                </div><!-- /recordclockontime -->                            
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="pill-pane" id="items">
                    <div class="well well-sm text-right">
                      <a class="btn btn-info" data-bind="click: $root.addInstructions"><span class="glyphicon glyphicon-comment"></span> New instructions</a>
                      <a class="btn btn-primary" data-bind="click: $root.addItem"><span class="glyphicon glyphicon-picture"></span> New item</a>
                      <a class="btn btn-warning" data-bind="click: $root.addLoop"><span class="glyphicon glyphicon-repeat"></span> New loop</a>
                    </div><!-- /items toolbar -->

<!-- ko foreach: items -->

      <div class="modal fade" data-bind="attr: {id: 'itemActions' + $index()}">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">Choose action...</h4>
            </div>
            <div class="modal-body">
              <div class="form-group clearfix">
                <a class="btn btn-danger col-xs-3" data-bind="click: $root.removeItem" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Remove</a>
                <span class="col-xs-2"></span>
                <span class="col-xs-7">Warning! This action cannot be undone.</span>
              </div>
              <hr/>
              <div class="form-group clearfix">
                <a class="btn btn-primary col-xs-3" data-bind="click: $root.cloneItem" data-dismiss="modal"><span class="glyphicon glyphicon-tasks"></span>-<span class="glyphicon glyphicon-tasks"></span> Clone</a>
                <span class="col-xs-2"></span>
                <span class="col-xs-7">Cloned item will be placed afterwards.</span>
              </div>
            </div>
            <div class="modal-footer">
              <button data-dismiss="modal" class="btn btn-default">Cancel</button>
            </div>
          </div>
        </div>
      </div>

<!-- ko if: type == "loop" -->

      <div class="modal fade" data-bind="attr: {id: 'loopVariables' + $index()}">
        <div class="modal-dialog modal-width">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">Set variables...</h4>
            </div>
            <div class="modal-body">
              <h4 class="modal-title">Variable list for loop <span data-bind="text: '#' + ($index() + 1)" /></h4>
              <div class="modal-body modal-scrollable">
                <table data-bind='visible: variables().length > 0'>
                  <thead>
                    <tr>
                      <th class="min"></th>
                      <th>Name / Iteration</th>
<!-- ko foreach: new Array(parseInt(description())) -->
                      <th><span data-bind="text: '#' + ($index()+1)" /></span></th>
<!-- /ko -->
                    </tr>
                  </thead>
                  <tbody data-bind="foreach: variables">
                    <tr>
                      <td class="min"><a href='#' class="btn btn-warning btn-sm" data-bind='click: $root.removeVariable'><span class="glyphicon glyphicon-remove"></span></a></td>
                      <td><input class="form-control input-sm" data-bind='value: name' placeholder='Set name'/></td>
<!-- ko foreach: values -->
                      <td><input class="form-control input-sm" data-bind='value: v' placeholder='Set value'/></td>
<!-- /ko -->
                    </tr>
                  </tbody>
                </table>
              </div>
              <hr />
              <a class="btn btn-warning btn-sm" data-bind='click: $root.addVariable'><span class="glyphicon glyphicon-plus"></span> Add variable</a>
              <a class="btn btn-warning btn-sm" data-bind='visible: showcsv, click: $root.toggleCSV'><span class="glyphicon glyphicon-chevron-up"></span> Import variables</a>
              <a class="btn btn-warning btn-sm" data-bind='visible: !showcsv(), click: $root.toggleCSV'><span class="glyphicon glyphicon-chevron-down"></span> Import variables</a>
              <div data-bind='visible: showcsv'>
                <hr />
                <h4 class="modal-title">Import variables from CSV</h4>
                <div class="form-group">
                    <label>Paste here a comma-separated list of variables and values...</label>
                    <textarea class="form-control" rows="3" data-bind="attr: {id: 'importTextarea' + $index()}, value: itemcsv, valueUpdate:['afterkeydown','propertychange','input']" placeholder="Name,1,2,3,4,5..."></textarea>
                </div>
                <a href='#' class="btn btn-warning btn-sm" data-content="Importing" data-bind="click: $root.importVariables"><span class="glyphicon glyphicon-th"></span> Import</a>
              </div>
            </div>
            <div class="modal-footer">
              <button data-dismiss="modal" class="btn btn-default">Done</button>
            </div>
          </div>
        </div>
      </div>

<!-- /ko -->

<!-- /ko -->

                    <ul class="list-unstyled" data-bind="foreach: items, sortable: items">
                      <li>
<!-- ko if: type == "instructions" -->
                      <div class="panel panel-info">
                        <div class="panel-heading clearfix" data-bind="click: $root.toggleItem">
                          <div class="col-sm-8">
                            <h3 class="panel-title"><span class="label label-default" data-bind="text: $index() + 1"></span> <span class="glyphicon glyphicon-comment"></span> <span data-bind="text: description"></span></h3>
                          </div>
                          <div class="col-sm-4 text-right">
                            <a class="btn btn-info btn-xs" data-toggle="modal" data-bind="click: $root.toggleItem, attr: {href: '#itemActions' + $index()}"><span class="glyphicon glyphicon-wrench"></span></a>
                            <a class="btn btn-info btn-xs" data-bind="visible: show"><span class="glyphicon glyphicon-chevron-up"></span></a>
                            <a class="btn btn-info btn-xs" data-bind="visible: !show()"><span class="glyphicon glyphicon-chevron-down"></span></a>
                          </div>
                        </div>
                        <div class="panel-body" data-bind="visible: show">
                          <form class="form-horizontal">
                            <div class="form-group">
                              <label class="col-lg-2 control-label">Description</label>
                              <div class="col-lg-10">
                                <input class="form-control" placeholder="This description is aimed to be helpful during the editing process, but will not be exported to DMDX." type="text" data-bind="value: description">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-lg-2 control-label">Text</label>
                              <div class="col-lg-10">
                                <textarea class="form-control" rows="3" data-bind="value: content" placeholder="Type your instructions here"></textarea>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div><!-- /instructions -->
<!-- /ko -->
<!-- ko if: type == "item" -->
                      <div class="panel panel-primary">
                        <div class="panel-heading clearfix" data-bind="click: $root.toggleItem">
                          <div class="col-sm-8">
                            <h3 class="panel-title"><span class="label label-default" data-bind="text: $index() + 1"></span> <span class="glyphicon glyphicon-picture"></span> <span data-bind="text: description"></span></h3>
                          </div>
                          <div class="col-sm-4 text-right">
                            <a class="btn btn-primary btn-xs" data-toggle="modal" data-bind="click: $root.toggleItem, attr: {href: '#itemActions' + $index()}"><span class="glyphicon glyphicon-wrench"></span></a>
                            <a class="btn btn-primary btn-xs" data-bind="visible: show"><span class="glyphicon glyphicon-chevron-up"></span></a>
                            <a class="btn btn-primary btn-xs" data-bind="visible: !show()"><span class="glyphicon glyphicon-chevron-down"></span></a>
                          </div>
                        </div>
                        <div class="panel-body" data-bind="visible: show">
                          <form class="form-horizontal">
                            <div class="form-group">
                              <label class="col-lg-2 control-label">Description</label>
                              <div class="col-lg-10">
                                <input class="form-control" placeholder="This description is aimed to be helpful during the editing process, but will not be exported to DMDX." type="text" data-bind="value: description">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-lg-2 control-label">Response</label>
<!-- ko if: !varresponse() -->
                              <div class="col-lg-9" data-bind="visible: !varresponse()">
                                <select class="form-control" data-bind="options: ['Positive', 'Negative', 'Any', 'No response'], optionsText: function(response) { return response; }, optionsValue: function(response) { return response.toLowerCase(); }, value: response, disable: varresponse"></select> 
                              </div>
<!-- /ko -->
<!-- ko if: varresponse -->
                              <div class="col-lg-9" data-bind="visible: varresponse">
                                <input class="form-control" type="text" data-bind="value: response">
                              </div>
<!-- /ko -->
                              <div class="col-lg-1">
                                <a class="btn btn-warning btn-sm" data-bind="click: varresponse.toggle()"><span class="glyphicon glyphicon-refresh"></span></a>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-lg-2 control-label">Clock on</label>
                              <div class="col-lg-9" data-bind="visible: !varclockon()">
                                <select class="form-control" data-bind="options: stimuli, optionsText: function(stimulus) { var i = stimuli.indexOf(stimulus) + 1, desc = ''; return i + '. ' + stimulus.val() + ' (' +  stimulus.format + ')'; }, optionsValue: function(stimulus) { return stimuli.indexOf(stimulus) + 1; }, value: clockon"></select>
                              </div>
                              <div class="col-lg-9" data-bind="visible: varclockon">
                                <input class="form-control" type="text" data-bind="value: clockon">
                              </div>
                              <div class="col-lg-1">
                                <a class="btn btn-warning btn-sm" data-bind="click: varclockon.toggle()"><span class="glyphicon glyphicon-refresh"></span></a>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-lg-2 control-label">Add stimuli</label>
                              <div class="col-lg-10">
                                <div class="well well-sm text-right">
                                  <a class="btn btn-primary" data-bind="click: $root.addBlankStimulus"><span class="glyphicon glyphicon-unchecked"></span> Blank</a>
                                  <a class="btn btn-primary" data-bind="click: $root.addTextStimulus"><span class="glyphicon glyphicon-comment"></span> Text</a>
                                  <a class="btn btn-primary" data-bind="click: $root.addBmpStimulus"><span class="glyphicon glyphicon-picture"></span> BMP</a>
                                  <a class="btn btn-primary" data-bind="click: $root.addJpgStimulus"><span class="glyphicon glyphicon-picture"></span> JPG</a>
                                  <a class="btn btn-primary" data-bind="click: $root.addWavStimulus"><span class="glyphicon glyphicon-volume-up"></span> WAV</a>
                                  <a class="btn btn-primary" data-bind="click: $root.addVideoStimulus"><span class="glyphicon glyphicon-film"></span> Video</a>
                                  <a class="btn btn-primary" data-bind='visible: showcsv, click: $root.toggleCSV'><span class="glyphicon glyphicon-chevron-up"></span> Import stimuli</a>
                                  <a class="btn btn-primary" data-bind='visible: !showcsv(), click: $root.toggleCSV'><span class="glyphicon glyphicon-chevron-down"></span> Import stimuli</a>
                                  <div data-bind='visible: showcsv'>
                                    <hr />
                                    <h4>Import stimuli from CSV</h4>
                                    <div>
                                        <label>Paste here a comma-separated list of stimuli and properties...<br />(start with the type of stimulus -blank, text, etc.- and then add its properties in order)</label>
                                        <textarea class="form-control" rows="3" data-bind="attr: {id: 'importTextarea' + $index()}, value: itemcsv, valueUpdate:['afterkeydown','propertychange','input']" placeholder="text,word,30,true,center,middle"></textarea>
                                    </div>
                                    <br />
                                    <a href='#' class="btn btn-primary btn-sm" data-content="Importing" data-bind="click: $root.importStimuli"><span class="glyphicon glyphicon-th"></span> Import</a>
                                  </div>
                                </div><!-- /stimuli toolbar -->
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-lg-2 control-label">Stimuli</label>
                              <div class="col-lg-10">
                                <ul class="list-unstyled" data-bind="foreach: stimuli, sortable: stimuli">
                                  <li>
                      <div class="panel panel-primary">
                        <div class="panel-heading clearfix" data-bind="click: $root.toggleStimulus">
                          <div class="col-sm-8">
<!-- ko if: format == "blank" -->
                            <h3 class="panel-title"><span class="label label-default" data-bind="text: $index() + 1"></span> <span class="glyphicon glyphicon-unchecked"></span> <span data-bind="text: duration"></span> ticks</h3>
<!-- /ko -->
<!-- ko if: format == "text" -->
                            <h3 class="panel-title"><span class="label label-default" data-bind="text: $index() + 1"></span> <span class="glyphicon glyphicon-comment"></span> <span data-bind="text: val"></span></h3>
<!-- /ko -->
<!-- ko if: format == "bmp" || format == "jpg" -->
                            <h3 class="panel-title"><span class="label label-default" data-bind="text: $index() + 1"></span> <span class="glyphicon glyphicon-picture"></span> <span data-bind="text: val"></span>.<span data-bind="text: format"></span></h3>
<!-- /ko -->
<!-- ko if: format == "wav" -->
                            <h3 class="panel-title"><span class="label label-default" data-bind="text: $index() + 1"></span> <span class="glyphicon glyphicon-volume-up"></span> <span data-bind="text: val"></span>.<span data-bind="text: format"></span></h3>
<!-- /ko -->
<!-- ko if: format == "dv" -->
                            <h3 class="panel-title"><span class="label label-default" data-bind="text: $index() + 1"></span> <span class="glyphicon glyphicon-film"></span> <span data-bind="text: val"></span>.<span data-bind="text: format"></span></h3>
<!-- /ko -->
                          </div>
                          <div class="col-sm-4 text-right">
                            <a class="btn btn-primary btn-xs" data-bind="visible: show"><span class="glyphicon glyphicon-chevron-up"></span></a>
                            <a class="btn btn-primary btn-xs" data-bind="visible: !show()"><span class="glyphicon glyphicon-chevron-down"></span></a>
                            <a class="btn btn-primary btn-xs" data-bind="click: $root.removeStimulus"><span class="glyphicon glyphicon-remove"></span></a>
                          </div>
                        </div>
                        <div class="panel-body" data-bind="visible: show">
<!-- ko if: format == "text" -->
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Text</label>
                            <div class="col-lg-10">
                              <input class="form-control" placeholder="Type here." type="text" data-bind="value: val">
                            </div>
                          </div>
<!-- /ko -->
<!-- ko if: format == "bmp" || format == "jpg" || format == "wav" || format == "dv" -->                         
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Filename</label>
                            <div class="col-lg-10">
                              <input class="form-control" placeholder="Filename without extension." type="text" data-bind="value: val">
                            </div>
                          </div>
<!-- /ko -->
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Duration (ticks)</label>
                            <div class="col-lg-9" data-bind="visible: !varduration()">
                              <input class="form-control" type="number" min="1" data-bind="value: duration">
                            </div>
                            <div class="col-lg-9" data-bind="visible: varduration">
                              <input class="form-control" type="text" data-bind="value: duration">
                            </div>
                            <div class="col-lg-1">
                              <a class="btn btn-warning btn-sm" data-bind="click: varduration.toggle()"><span class="glyphicon glyphicon-refresh"></span></a>
                            </div>
                          </div>
<!-- ko if: format != "blank" -->
                          <div class="form-group">
                            <label class="control-label col-xs-2">Clear screen</label>
                            <div class="col-lg-9" data-bind="visible: !varclear()">
                              <span class="col-xs-8"></span>
                              <div class="col-xs-4">
                                <div class="switch switch-2">
                                  <input type="radio" value="true" data-bind="checked: clear, attr: {id: 'clearyes' + $index()}">
                                  <label data-bind="attr: {for: 'clearyes' + $index()}"><span class="glyphicon glyphicon-ok"></span></label>
                                  <input type="radio" value="false" data-bind="checked: clear, attr: {id: 'clearno' + $index()}">
                                  <label data-bind="attr: {for: 'clearno' + $index()}"><span class="glyphicon glyphicon-remove"></span></label>
                                  <span class="slide-button btn btn-success"></span>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-9" data-bind="visible: varclear">
                              <input class="form-control" type="text" data-bind="value: clear">
                            </div>
                            <div class="col-lg-1">
                              <a class="btn btn-warning btn-sm" data-bind="click: varclear.toggle()"><span class="glyphicon glyphicon-refresh"></span></a>
                            </div>
                          </div>
<!-- /ko -->
<!-- ko if: format == "wav" -->
                          <div class="form-group">
                            <label class="control-label col-xs-2">Sync with text</label>
                            <div class="col-lg-9" data-bind="visible: !varsyncText()">
                              <span class="col-xs-8"></span>
                              <div class="col-xs-4">
                                <div class="switch switch-2">
                                  <input type="radio" value="true" data-bind="checked: syncText, attr: {id: 'syncTextyes' + $index()}">
                                  <label data-bind="attr: {for: 'syncTextyes' + $index()}"><span class="glyphicon glyphicon-ok"></span></label>
                                  <input type="radio" value="false" data-bind="checked: syncText, attr: {id: 'syncTextno' + $index()}">
                                  <label data-bind="attr: {for: 'syncTextno' + $index()}"><span class="glyphicon glyphicon-remove"></span></label>
                                  <span class="slide-button btn btn-success"></span>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-9" data-bind="visible: varsyncText">
                              <input class="form-control" type="text" data-bind="value: syncText">
                            </div>
                            <div class="col-lg-1">
                              <a class="btn btn-warning btn-sm" data-bind="click: varsyncText.toggle()"><span class="glyphicon glyphicon-refresh"></span></a>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Channel</label>
                            <div class="col-lg-9" data-bind="visible: !varhorizontal()">
                              <select class="form-control" data-bind="options: ['Left', 'Both', 'Right'], optionsText: function(place) { return place; }, optionsValue: function(place) { return place.toLowerCase(); }, value: horizontal"></select>
                            </div>
                            <div class="col-lg-9" data-bind="visible: varhorizontal">
                              <input class="form-control" type="text" data-bind="value: horizontal">
                            </div>
                            <div class="col-lg-1">
                              <a class="btn btn-warning btn-sm" data-bind="click: varhorizontal.toggle()"><span class="glyphicon glyphicon-refresh"></span></a>
                            </div>
                          </div>
<!-- /ko -->
<!-- ko if: format == "bmp" || format == "jpg" || format == "dv" -->
                          <div class="form-group">
                            <label class="control-label col-xs-2">Full screen</label>
                            <div class="col-lg-9" data-bind="visible: !varfullScreen()">
                              <span class="col-xs-8"></span>
                              <div class="col-xs-4">
                                <div class="switch switch-2">
                                  <input type="radio" value="true" data-bind="checked: fullScreen, attr: {id: 'fullScreenyes' + $index()}">
                                  <label data-bind="attr: {for: 'fullScreenyes' + $index()}"><span class="glyphicon glyphicon-ok"></span></label>
                                  <input type="radio" value="false" data-bind="checked: fullScreen, attr: {id: 'fullScreenno' + $index()}">
                                  <label data-bind="attr: {for: 'fullScreenno' + $index()}"><span class="glyphicon glyphicon-remove"></span></label>
                                  <span class="slide-button btn btn-success"></span>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-9" data-bind="visible: varfullScreen">
                              <input class="form-control" type="text" data-bind="value: fullScreen">
                            </div>
                            <div class="col-lg-1">
                              <a class="btn btn-warning btn-sm" data-bind="click: varfullScreen.toggle()"><span class="glyphicon glyphicon-refresh"></span></a>
                            </div>
                          </div>
<!-- /ko -->
<!-- ko if: format == "text" || format == "bmp" || format == "jpg" || format == "dv" -->
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Horizontal position</label>
                            <div class="col-lg-9" data-bind="visible: !varhorizontal()">
                              <select class="form-control" data-bind="options: ['Left', 'Center', 'Right'], optionsText: function(place) { return place; }, optionsValue: function(place) { return place.toLowerCase(); }, value: horizontal"></select>
                            </div>
                            <div class="col-lg-9" data-bind="visible: varhorizontal">
                              <input class="form-control" type="text" data-bind="value: horizontal">
                            </div>
                            <div class="col-lg-1">
                              <a class="btn btn-warning btn-sm" data-bind="click: varhorizontal.toggle()"><span class="glyphicon glyphicon-refresh"></span></a>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Vertical position</label>
                            <div class="col-lg-9" data-bind="visible: !varvertical()">
                              <select class="form-control" data-bind="options: ['Top', 'Middle', 'Bottom'], optionsText: function(place) { return place; }, optionsValue: function(place) { return place.toLowerCase(); }, value: vertical"></select>
                            </div>
                            <div class="col-lg-9" data-bind="visible: varvertical">
                              <input class="form-control" type="text" data-bind="value: vertical">
                            </div>
                            <div class="col-lg-1">
                              <a class="btn btn-warning btn-sm" data-bind="click: varvertical.toggle()"><span class="glyphicon glyphicon-refresh"></span></a>
                            </div>
                          </div>
<!-- /ko -->
                        </div>
                      </div>
                                  </li>
                                </ul>
                              </div>
                            </div>

                          </form>
                        </div>
                      </div><!-- /item -->
<!-- /ko -->
<!-- ko if: type == "loop" -->
                      <div class="panel panel-warning">
                        <div class="panel-heading clearfix" data-bind="click: $root.toggleItem">
                          <div class="col-sm-8">
                            <h3 class="panel-title"><span class="label label-default" data-bind="text: $index() + 1"></span> <span class="glyphicon glyphicon-repeat"></span> Loop <span class="label label-primary" data-bind="text: description"></span> times, from <span class="label label-default" data-bind="text: $index() + 1"></span> to <span class="label label-default" data-bind="text: content"></span> <span data-bind="text: scramble() == 'true' ? 'scrambling items' : ''"></span></h3>
                          </div>
                          <div class="col-sm-4 text-right">
                            <a class="btn btn-warning btn-xs" data-toggle="modal" data-bind="click: $root.toggleItem, attr: {href: '#itemActions' + $index()}"><span class="glyphicon glyphicon-wrench"></span></a>
                            <a class="btn btn-warning btn-xs" data-bind="visible: show"><span class="glyphicon glyphicon-chevron-up"></span></a>
                            <a class="btn btn-warning btn-xs" data-bind="visible: !show()"><span class="glyphicon glyphicon-chevron-down"></span></a>
                          </div>
                        </div>
                        <div class="panel-body" data-bind="visible: show">
                          <form class="form-horizontal">
                            <div class="form-group">
                              <label class="col-lg-2 control-label">Iterations</label>
                              <div class="col-lg-10">
                                <input class="form-control" type="number" min="1" data-bind="value: description">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-xs-2">Scramble</label>
                              <span class="col-xs-8"></span>
                              <div class="col-xs-2">
                                <div class="switch switch-2">
                                  <input type="radio" value="true" data-bind="checked: scramble, attr: {id: 'scrambleyes' + $index()}">
                                  <label data-bind="attr: {for: 'scrambleyes' + $index()}"><span class="glyphicon glyphicon-ok"></span></label>
                                  <input type="radio" value="false" data-bind="checked: scramble, attr: {id: 'scrambleno' + $index()}">
                                  <label data-bind="attr: {for: 'scrambleno' + $index()}"><span class="glyphicon glyphicon-remove"></span></label>
                                  <span class="slide-button btn btn-success"></span>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-lg-2 control-label">From <span data-bind="text: $index() + 1"></span> to</label>
                              <div class="col-lg-10">
                                <select class="form-control" data-bind="options: $root.items().slice($index()+1), optionsText: function(item) { var i = $root.items().indexOf(item) + 1, desc = ''; if (item.type != 'loop') { return i + '. ' + item.description(); } else { return i + '. Loop'; } }, optionsValue: function(item) { return $root.items().indexOf(item) + 1; }, value: content"></select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-xs-2 control-label">Variables</label>
                              <div class="col-xs-10 text-right">
                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-bind="click: $root.toggleItem, attr: {href: '#loopVariables' + $index()}, click: $root.populateValues"><span class="glyphicon glyphicon-refresh"></span> Set variables</a>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div><!-- /loop -->
<!-- /ko -->
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="import">
              <form class="form-horizontal">
                <div class="well well-sm text-right">
                  <button id="importbutton" class="popover-link btn btn-warning" data-toggle="popover" data-placement="left" data-content="Importing" data-bind="click: $root.importFromJSON"><span class="glyphicon glyphicon-import"></span> Import from JSON</button>
                </div>
                <textarea id="fromjson" class="form-control" rows="15" cols="80" placeholder="Paste here your experiment in JSON format"></textarea>
              </form>
            </div>
            <div class="tab-pane" id="export">
              <form class="form-horizontal">
                <div class="well well-sm text-right">
                  <div class="">
                    <label class="col-xs-1">Verbose keywords</label>
                    <div class="col-xs-1"></div>
                    <div class="col-xs-2">
                      <div class="switch switch-2">
                        <input id="verboseyes" name="verboseyes" type="radio" value="true" data-bind="checked: verbose">
                        <label for="verboseyes"><span class="glyphicon glyphicon-ok"></span></label>
                        <input id="verboseno" name="verboseno" type="radio" value="false" data-bind="checked: verbose">
                        <label for="verboseno"><span class="glyphicon glyphicon-remove"></span></label>
                        <span class="slide-button btn btn-success"></span>
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-primary" data-bind="click: exportToDMDX"><span class="glyphicon glyphicon-export"></span> Export to DMDX</button>
                  <button class="btn btn-warning" data-bind="click: exportToJSON"><span class="glyphicon glyphicon-export"></span> Export to JSON</button>
                </div>
                <textarea class="form-control" data-bind="value: lastExport" rows="15" cols="80"></textarea>
              </form>
            </div>
            <div class="tab-pane" id="preview">
              <form class="form-horizontal">
                <div class="well well-sm text-right">
                  <button id="previewbutton" class="popover-link btn btn-primary" data-toggle="popover" data-placement="left" data-content="Generating" data-bind="click: $root.createPreview"><span class="glyphicon glyphicon-film"></span> Generate preview</button>
                </div>
              </form>
              <div class="preview-container">
                <div class="preview-box">
                   <span id="previewdump"></span>
                </div>
              </div>
            </div>
           </div>
        </div>
        <!-- /tabs -->
      </div>

      <div class="modal fade" id="helpModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
              <iframe id="iframeHelpModal" src="" width="100%" height="400px"></iframe>
            </div>
            <div class="modal-footer">
              <button data-dismiss="modal" class="btn btn-default">OK</button>
            </div>
          </div>
        </div>
      </div>

