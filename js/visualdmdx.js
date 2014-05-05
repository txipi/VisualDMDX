var initialData = initialData || {
  id: "dummy",
  description: "",
  verbose: "true",
  parameters: { videomode: {} },
  items: []
};

// KO SetAt
ko.observableArray.fn.setAt = function(index, value) {
    this.valueWillMutate();
    this()[index] = value;
    this.valueHasMutated();
}

// KO toggle
ko.observable.fn.toggle = function () {
    var obs = this;
    return function () {
        obs(!obs())
    };
};

// Extended KO Binding
ko.bindingHandlers.sortable = {
    init: function (element, valueAccessor) {
        // cached vars for sorting events
        var startIndex = -1,
            koArray = valueAccessor();
        
        var sortableSetup = {
            // cache the item index when the dragging starts
            start: function (event, ui) {
                startIndex = ui.item.index();
                
                // set the height of the placeholder when sorting
                ui.placeholder.height(ui.item.height());
            },
            // capture the item index at end of the dragging
            // then move the item
            stop: function (event, ui) {
                
                // get the new location item index
                var newIndex = ui.item.index();
                
                if (startIndex > -1) {
                    //  get the item to be moved
                    var item = koArray()[startIndex];
                     
                    //  remove the item
                    koArray.remove(item);
                    
                    //  insert the item back in to the list
                    koArray.splice(newIndex, 0, item);

                    //  ko rebinds the array so we need to remove duplicate ui item
                    ui.item.remove();
                }

            },
            placeholder: 'itemMoving'
        };
        
        // bind
        $(element).sortable( sortableSetup );  
    }
};

var Item = function (item) {
  this.type = item.type;
  this.description = ko.observable(item.description);
  this.content = ko.observable(item.content);
  this.response = ko.observable(item.response);
  this.varresponse = ko.observable(item.varresponse || false);
  this.scramble = ko.observable(item.scramble);
  this.clockon = ko.observable(item.clockon);
  this.varclockon = ko.observable(item.varclockon || false);
  this.show = ko.observable(item.show);
  this.stimuli = ko.observableArray(ko.utils.arrayMap(item.stimuli, function(stimulus) {
    return {
      format: stimulus.format, 
      val: ko.observable(stimulus.val), 
      duration: ko.observable(stimulus.duration), 
      varduration: ko.observable(stimulus.varduration || false), 
      clear: ko.observable(stimulus.clear), 
      varclear: ko.observable(stimulus.varclear || false), 
      syncText: ko.observable(stimulus.syncText), 
      varsyncText: ko.observable(stimulus.varsyncText || false), 
      fullScreen: ko.observable(stimulus.fullScreen), 
      varfullScreen: ko.observable(stimulus.varfullScreen || false), 
      horizontal: ko.observable(stimulus.horizontal), 
      varhorizontal: ko.observable(stimulus.varhorizontal || false), 
      vertical: ko.observable(stimulus.vertical), 
      varvertical: ko.observable(stimulus.varvertical || false), 
      show: ko.observable(stimulus.show) 
    };
  }));
  this.variables = ko.observableArray(ko.utils.arrayMap(item.variables, function(variable) {
    return {
      name: ko.observable(variable.name), 
      values: ko.observableArray(ko.utils.arrayMap(variable.values, function(value) {
        return {
          loop: value.loop, 
          v: ko.observable(value.v)
        };
      }))
    };
  }));
  this.itemcsv = ko.observable(item.itemcsv);
  this.showcsv = ko.observable(item.showcsv || false);
}

var DMDXModel = function(initial) {
  var self = this;

  //Initialization

  self.id = initial.id || "";
  self.version = initial.version || 0;
  self.description = ko.observable(initial.description || "");
  self.verbose = ko.observable(initial.verbose || "true");
  self.parameters = {};
  self.parameters.timeout = ko.observable(initial.parameters.timeout || "1000");
  self.parameters.keyboard = ko.observable(initial.parameters.keyboard || "true");
  self.parameters.mouse = ko.observable(initial.parameters.mouse || "false");
  self.parameters.PIO12 = ko.observable(initial.parameters.PIO12 || "false");
  self.parameters.digitalvox = ko.observable(initial.parameters.digitalvox || "false");
  self.parameters.recordvocal = ko.observable(initial.parameters.recordvocal || "false");
  self.parameters.videomode = {};
  self.parameters.videomode.width = ko.observable(initial.parameters.videomode.width || "640");
  self.parameters.videomode.height = ko.observable(initial.parameters.videomode.height || "480");
  self.parameters.videomode.realheight = ko.observable(initial.parameters.videomode.realheight || "480");
  self.parameters.videomode.bpp = ko.observable(initial.parameters.videomode.bpp || "8");
  self.parameters.videomode.hz = ko.observable(initial.parameters.videomode.hz || "0");
  self.parameters.feedback = ko.observable(initial.parameters.feedback || "none");
  self.parameters.frameduration = ko.observable(initial.parameters.frameduration || "30");
  self.parameters.delay = ko.observable(initial.parameters.delay || "5");
  self.parameters.continuosrun = ko.observable(initial.parameters.continuosrun || "false");
  self.parameters.color = ko.observable(initial.parameters.color || "#ffffff");
  self.parameters.bgcolor = ko.observable(initial.parameters.bgcolor || "#000000");
  self.parameters.fontsize = ko.observable(initial.parameters.fontsize || "12");
  self.parameters.outputascii = ko.observable(initial.parameters.outputascii || "true");
  self.parameters.recordclockontime = ko.observable(initial.parameters.recordclockontime || "true");
  self.items = ko.observableArray(ko.utils.arrayMap(initial.items, function(item) { return new Item(item) }));

  self.lastExport = ko.observable("");

  //Functions

  self.saveChanges = function(item) {
    var clone = (JSON.parse(JSON.stringify(ko.toJS(self)))),
        data = ""
        experimentURL = '/save/' + clone.id;

    delete clone.lastExport;
    experiment = "json='" + encodeURIComponent(JSON.stringify(ko.toJS(clone), null)) + "'";

    $.ajax({
      data:  experiment,
      url:   experimentURL,
      type:  'POST',
      beforeSend: function () {
        $("#savebutton").attr("data-content", "Saving");
      },
      success:  function (response) {
        var save = $("#savebutton");
        save.popover("hide");
        save.attr("data-content", "Saved");
        save.popover("show");
        initialData.version++;
        $("#versionslinks").prepend('<li><a href="/edit/' + initialData.id + "/" + initialData.version + '"><span class="glyphicon glyphicon-cloud-download"></span> Version ' + initialData.version + '</a></li>');
      }
    });
  };

  self.toggleItem = function(item) {
    var state = !item.show();
    item.show(state);
  };

  self.removeItem = function(item) {
    var index = self.items.indexOf(item);
    $("#itemActions" + index).one('hidden.bs.modal', function () {
      self.items.remove(item);
    }).modal("hide");
  };

  self.cloneItem = function(item) {
    var index = self.items.indexOf(item),
        newitem = new Item(ko.toJS(item));
    $("#itemActions" + index).one('hidden.bs.modal', function () {
      self.items.splice(index, 0, newitem);
    }).modal("hide");
  };

  self.addInstructions = function() {
    self.items.push({
      type: "instructions", 
      description: ko.observable(""), 
      content: ko.observable(""),
      response: "no-response",
      varresponse: false,
      scramble: ko.observable("false"),
      clockon: "0",
      varclockon: false,
      show: ko.observable(false),
      stimuli: [],
      variables: [],
      itemcsv: "",
      showcsv: ko.observable(false),
    });
  };

  self.addItem = function() {
    self.items.push({
      type: "item", 
      description: ko.observable(""), 
      content: "",
      response: ko.observable("positive"),
      varresponse: ko.observable(false),
      scramble: ko.observable("false"),
      clockon: ko.observable("0"),
      varclockon: ko.observable(false),
      show: ko.observable(false),
      stimuli: ko.observableArray(),
      variables: [],
      itemcsv: ko.observable(""),
      showcsv: ko.observable(false),
    });
  };

  self.addLoop = function() {
    self.items.push({
      type: "loop", 
      description: ko.observable("1"), 
      content: ko.observable("1"),
      response: "no-response",
      varresponse: false,
      scramble: ko.observable("false"),
      clockon: "0",
      clockon: "0",
      show: ko.observable(false),
      stimuli: [],
      variables: ko.observableArray(),
      itemcsv: ko.observable(""),
      showcsv: ko.observable(false),
    });
  };

  self.toggleStimulus = function(stimulus) {
    var state = !stimulus.show();
    stimulus.show(state);
  };

  self.removeStimulus = function(stimulus) {
    $.each(self.items(), function() { if (this.type == "item") { this.stimuli.remove(stimulus) } });
  };

  self.addBlankStimulus = function(item) {
    item.stimuli.push({
          format: "blank", 
          val: ko.observable(""), 
          duration: ko.observable(self.parameters.frameduration()), 
          varduration: ko.observable(false),
          clear: ko.observable("true"), 
          varclear: ko.observable(false),
          syncText: "", 
          varsyncText: ko.observable(false),
          fullScreen: "", 
          varfullScreen: ko.observable(false),
          horizontal: "", 
          varhorizontal: ko.observable(false),
          vertical: "", 
          varvertical: ko.observable(false),
          show: ko.observable(false) 
    });
  };

  self.addTextStimulus = function(item) {
    item.stimuli.push({
          format: "text", 
          val: ko.observable("text"), 
          duration: ko.observable(self.parameters.frameduration()),
          varduration: ko.observable(false), 
          clear: ko.observable("true"), 
          varclear: ko.observable(false),
          syncText: "", 
          varsyncText: ko.observable(false),
          fullScreen: ko.observable("false"), 
          varfullScreen: ko.observable(false),
          horizontal: ko.observable("center"), 
          varhorizontal: ko.observable(false),
          vertical: ko.observable("middle"),
          varvertical: ko.observable(false),
          show: ko.observable(false) 
    });
  };

  self.addBmpStimulus = function(item) {
    item.stimuli.push({
          format: "bmp", 
          val: ko.observable(""), 
          duration: ko.observable(self.parameters.frameduration()), 
          varduration: ko.observable(false),
          clear: ko.observable("true"), 
          varclear: ko.observable(false),
          syncText: ko.observable("true"), 
          varsyncText: ko.observable(false),
          fullScreen: ko.observable("false"), 
          varfullScreen: ko.observable(false),
          horizontal: ko.observable("center"), 
          varhorizontal: ko.observable(false),
          vertical: ko.observable("middle"), 
          varvertical: ko.observable(false),
          show: ko.observable(false) 
    });
  };

  self.addJpgStimulus = function(item) {
    item.stimuli.push({
          format: "jpg", 
          val: ko.observable(""), 
          duration: ko.observable(self.parameters.frameduration()), 
          varduration: ko.observable(false),
          clear: ko.observable("true"), 
          varclear: ko.observable(false),
          syncText: ko.observable("true"),  
          varsyncText: ko.observable(false),
          fullScreen: ko.observable("false"), 
          varfullScreen: ko.observable(false),
          horizontal: ko.observable("center"), 
          varhorizontal: ko.observable(false),
          vertical: ko.observable("middle"), 
          varvertical: ko.observable(false),
          show: ko.observable(false) 
    });
  };

  self.addWavStimulus = function(item) {
    item.stimuli.push({
          format: "wav", 
          val: ko.observable(""), 
          duration: ko.observable(self.parameters.frameduration()), 
          varduration: ko.observable(false),
          clear: ko.observable("true"), 
          varclear: ko.observable(false),
          syncText: ko.observable("true"),  
          varsyncText: ko.observable(false),
          fullScreen: "", 
          varfullScreen: ko.observable(false),
          horizontal: ko.observable("both"), 
          varhorizontal: ko.observable(false),
          vertical: "", 
          varvertical: ko.observable(false),
          show: ko.observable(false) 
    });
  };

  self.addVideoStimulus = function(item) {
    item.stimuli.push({
          format: "dv", 
          val: ko.observable(""), 
          duration: ko.observable(self.parameters.frameduration()), 
          varduration: ko.observable(false),
          clear: ko.observable("true"), 
          varclear: ko.observable(false),
          syncText: ko.observable("true"),  
          varsyncText: ko.observable(false),
          fullScreen: ko.observable("false"), 
          varfullScreen: ko.observable(false),
          horizontal: ko.observable("center"), 
          varhorizontal: ko.observable(false),
          vertical: ko.observable("middle"), 
          varvertical: ko.observable(false),
          show: ko.observable(false) 
    });
  };

  self.populateValues = function(item) {
    var n = parseInt(item.description()),
        i, 
        j,
        val,
        found;
    ko.utils.arrayForEach(item.variables(), function(variable) {
      for (j = 1; j <= n; j++) {
        val = ko.utils.arrayFirst(variable.values(), function(value) {
          return parseInt(value.loop) == j;
        });
        if (!val) {
          variable.values.push({
            loop: ''+j, 
            v: ko.observable('')
          });
        }
      }
      variable.values(ko.utils.arrayFilter(variable.values(), function(value) {
        return parseInt(value.loop) <= n;
      }));
    });
  }

  self.removeVariable = function(variable) {
    $.each(self.items(), function() { if (this.type == "loop") { this.variables.remove(variable) } });
  };

  self.addVariable = function(item) {
    item.variables.push({
          name: ko.observable(''), 
          values: ko.observableArray() 
    });
    self.populateValues(item);
  };

  self.toggleCSV = function(item) {
    var state = !item.showcsv();
    item.showcsv(state);
  };

  self.importVariables = function(item) {
    var csv = item.itemcsv(),
        lines,
        i,
        j,
        varname = '',
        varvalues = [];
    lines = $.csv.toArrays(csv);
    for (i = 0; i < lines.length; i++) {
      varname = lines[i][0];
      varvalues = [];
      for (j = 1; j < lines[i].length; j++) {
        varvalues.push({loop: j, v: lines[i][j]});
      }
      item.variables.push({
        name: ko.observable(varname), 
        values: ko.observableArray(ko.utils.arrayMap(varvalues, function(value) {
          return {
            loop: value.loop, 
            v: ko.observable(value.v)
          };
        }))
      });
      self.populateValues(item);
    }
  };

  self.importStimuli = function(item) {
    var csv = item.itemcsv(),
        lines,
        i,
        j,
        format = '';
    lines = $.csv.toArrays(csv);
    for (i = 0; i < lines.length; i++) {
      format = lines[i][0];
      switch(format.toLowerCase()) {
        case "blank":
          item.stimuli.push({
            format: "blank", 
            val: ko.observable(""), 
            duration: ko.observable(lines[i][1]), 
            varduration: ko.observable(false),
            clear: ko.observable("true"), 
            varclear: ko.observable(false),
            syncText: "", 
            varsyncText: ko.observable(false),
            fullScreen: "", 
            varfullScreen: ko.observable(false),
            horizontal: "", 
            varhorizontal: ko.observable(false),
            vertical: "", 
            varvertical: ko.observable(false),
            show: ko.observable(false) 
          });
          break;
        case "text":
          item.stimuli.push({
            format: "text", 
            val: ko.observable(lines[i][1]), 
            duration: ko.observable(lines[i][2]),
            varduration: ko.observable(false), 
            clear: ko.observable(lines[i][3].toLowerCase()), 
            varclear: ko.observable(false),
            syncText: "", 
            varsyncText: ko.observable(false),
            fullScreen: ko.observable("false"), 
            varfullScreen: ko.observable(false),
            horizontal: ko.observable(lines[i][4].toLowerCase()), 
            varhorizontal: ko.observable(false),
            vertical: ko.observable(lines[i][5].toLowerCase()),
            varvertical: ko.observable(false),
            show: ko.observable(false) 
          });
          break;
        case "bmp":
          item.stimuli.push({
            format: "bmp", 
            val: ko.observable(lines[i][1]), 
            duration: ko.observable(lines[i][2]), 
            varduration: ko.observable(false),
            clear: ko.observable(lines[i][3].toLowerCase()), 
            varclear: ko.observable(false),
            syncText: ko.observable("true"), 
            varsyncText: ko.observable(false),
            fullScreen: ko.observable(lines[i][4].toLowerCase()), 
            varfullScreen: ko.observable(false),
            horizontal: ko.observable(lines[i][5].toLowerCase()), 
            varhorizontal: ko.observable(false),
            vertical: ko.observable(lines[i][6].toLowerCase()), 
            varvertical: ko.observable(false),
            show: ko.observable(false) 
          });
          break;
        case "jpg":
          item.stimuli.push({
            format: "jpg", 
            val: ko.observable(lines[i][1]), 
            duration: ko.observable(lines[i][2]), 
            varduration: ko.observable(false),
            clear: ko.observable(lines[i][3].toLowerCase()), 
            varclear: ko.observable(false),
            syncText: ko.observable("true"), 
            varsyncText: ko.observable(false),
            fullScreen: ko.observable(lines[i][4].toLowerCase()), 
            varfullScreen: ko.observable(false),
            horizontal: ko.observable(lines[i][5].toLowerCase()), 
            varhorizontal: ko.observable(false),
            vertical: ko.observable(lines[i][6].toLowerCase()), 
            varvertical: ko.observable(false),
            show: ko.observable(false) 
          });
          break;
        case "wav":
          item.stimuli.push({
            format: "wav", 
            val: ko.observable(lines[i][1]), 
            duration: ko.observable(lines[i][2]), 
            varduration: ko.observable(false),
            clear: ko.observable(lines[i][3].toLowerCase()), 
            varclear: ko.observable(false),
            clear: ko.observable(lines[i][4].toLowerCase()), 
            varsyncText: ko.observable(false),
            fullScreen: "", 
            varfullScreen: ko.observable(false),
            horizontal: ko.observable(lines[i][5].toLowerCase()), 
            varhorizontal: ko.observable(false),
            vertical: "", 
            varvertical: ko.observable(false),
            show: ko.observable(false) 
          });
          break;
        case "dv":
        case "video":
          item.stimuli.push({
            format: "dv", 
            val: ko.observable(lines[i][1]), 
            duration: ko.observable(lines[i][2]), 
            varduration: ko.observable(false),
            clear: ko.observable(lines[i][3].toLowerCase()), 
            varclear: ko.observable(false),
            syncText: ko.observable("true"), 
            varsyncText: ko.observable(false),
            fullScreen: ko.observable(lines[i][4].toLowerCase()), 
            varfullScreen: ko.observable(false),
            horizontal: ko.observable(lines[i][5].toLowerCase()), 
            varhorizontal: ko.observable(false),
            vertical: ko.observable(lines[i][6].toLowerCase()), 
            varvertical: ko.observable(false),
            show: ko.observable(false) 
          });
          break;
      }
    }
  };

  self.hexToKilo = function (hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex),
        r = ("00"+parseInt(result[1], 16)).slice(-3), 
        g = ("00"+parseInt(result[2], 16)).slice(-3), 
        b = ("00"+parseInt(result[3], 16)).slice(-3);
    return result ? r + "" + g + "" + b : null;
  };

  self.showHelp = function (topic) {
    var urls = {
          "t": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhtimeoutkeyword.htm",
          "d": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhdelaykeyword.htm",
          "dfd": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhdefaultframedurationkeyword.htm",
          "id": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhinputdevicekeyword.htm",
          "nfb": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhnofeedbackkeyword.htm",
          "cr": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhcontinuousrunkeyword.htm",
          "dwc": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhdefaultwritingcolorkeyword.htm",
          "dbc": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhdefaultbackgroundcolorkeyword.htm",
          "dfs": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhdefaultfontsizekeyword.htm",
          "azk": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhazkiiresponseskeyword.htm",
          "rcot": "http://psy1.psych.arizona.edu/~jforster/dmdx/help/dmdxhrecordclockontimekeyword.htm"
        }, 
        frameSrc = urls[topic];

    $("#iframeHelpModal").attr("src", frameSrc);
    $("#helpModal").modal("show");
  };

  self.exportToDMDX = function() {
    var parametersExport = "",
        itemsExport = "",
        i = 0,
        j = 0,  
        it = self.unrollItems(),
        lines =0, 
        l = 0,
        a = 0,
        stim = [],
        h = -1,
        v = -1;

    if (self.verbose() == "true") {
      // Parameters options...
      parametersExport += "<ExtendedParameters> ";
      parametersExport += "<Timeout " + self.parameters.timeout() + "> ";
      parametersExport += "<Delay " + self.parameters.delay() + "> ";
      parametersExport += "<DefaultFrameDuration " + self.parameters.frameduration() + "> ";
      if (self.parameters.keyboard() == "true") {
        parametersExport += "<InputDevice keyboard> ";
      }
      if (self.parameters.mouse() == "true") {
        parametersExport += "<InputDevice mouse> ";
      }
      if (self.parameters.PIO12() == "true") {
        parametersExport += "<InputDevice PIO12> ";
      }
      if (self.parameters.digitalvox() == "true") {
        parametersExport += "<InputDevice digitalvox> ";
      }
      if (self.parameters.recordvocal() == "true") {
        parametersExport += "<InputDevice recordvocal> ";
      }
      parametersExport += "<VideoMode " + self.parameters.videomode.width() + ", " + self.parameters.videomode.height() + ", " + self.parameters.videomode.realheight() + ", " + self.parameters.videomode.bpp() + ", " + self.parameters.videomode.hz() + "> ";
      switch (self.parameters.feedback()) {
        case "none": 
          parametersExport += "<NoFeedback> ";
          break;
        case "outcome": 
          parametersExport += "<NoFeedbackTime> ";
          break;
        case "outcome and rt": 
          parametersExport += "";
          break;
      }
      if (self.parameters.continuosrun() == "true") {
        parametersExport += "<ContinuousRun> ";
      }
      parametersExport += "<DefaultWritingColor " + self.hexToKilo(self.parameters.color()) + "> ";
      parametersExport += "<DefaultBackgroundColor " + self.hexToKilo(self.parameters.bgcolor()) + "> ";
      parametersExport += "<DefaultFontSize " + self.parameters.fontsize() + "> ";
      if (self.parameters.outputascii() == "true") {
        parametersExport += "<AzkiiResponses> ";
      }
      if (self.parameters.recordclockontime() == "true") {
        parametersExport += "<RecordClockOnTime> ";
      }

      parametersExport += "\n<! -------------------------------------------------- >\n";
      parametersExport += "<! Experiment: " + self.description() + ">\n";
      parametersExport += "<! Created using Visual DMDX: ";
      parametersExport += "http://visualdmdx.com/edit/" + self.id + " >\n";
      parametersExport += "<! -------------------------------------------------- >\n";
      parametersExport += "<EndOfParameters>\n"

      // Items...

      for (i = 0; i < it.length; i++) {
        switch (it[i].type.toLowerCase()) {
          case "instructions":
            itemsExport += "00 ";
            lines = it[i].content.split(/\r|\r\n|\n/);
            if (lines.length > 1) {
              l = Math.round(lines.length/2);
              itemsExport += "<TextRow " + (-1*l+1) + "> \"" + lines[0] + "\"";
              for (j = 1; j < lines.length; j++) {
                itemsExport += ", \n    <TextRow " + (j-l+1) + "> \"" + lines[j] + "\"";
              }
            } else {
              itemsExport += "\"" + lines[0] + "\"";
            }
            itemsExport += "; \n"; 
            break;
          case "item":
            stim = it[i].stimuli;
            if (stim.length > 0) {
              switch (it[i].response.toLowerCase()) {
                case "positive":
                  itemsExport += "+";
                  break;
                case "negative":
                  itemsExport += "-";
                  break;
                case "no-response":
                  itemsExport += "^";
                  break;
                case "any":
                  itemsExport += "=";
                  break;
              }
              itemsExport += (i+1) + " ";
              for (j = 0; j < stim.length; j++) {
                if (it[i].clockon == j + 1) {
                  itemsExport += "* ";
                }
                switch (stim[j].format.toLowerCase()) {
                  case "blank":
                    if (self.parameters.frameduration() != stim[j].duration) {
                      itemsExport += "<FrameDuration " + stim[j].duration + "> ";
                    }
                    break;
                  case "text":
                  case "bmp":
                  case "jpg":
                  case "dv":
                    if (self.parameters.frameduration() != stim[j].duration) {
                      itemsExport += "<FrameDuration " + stim[j].duration + "> ";
                    }
                    if (stim[j].fullScreen.toLowerCase() == "true") {
                      if (stim[j].format.toLowerCase() != "text") {
                        itemsExport += "<" + stim[j].format + " 0, 0, 0, 0> ";
                      }
                    } else {
                      switch (stim[j].horizontal.toLowerCase()) {
                        case "left":
                          h = "0.25";
                          break;
                        case "center":
                          h = "0.5";
                          break;
                        case "right":
                          h = "0.75";
                          break;
                      }
                      switch (stim[j].vertical.toLowerCase()) {
                        case "top":
                          v = "0.25";
                          break;
                        case "middle":
                          v = "0.5";
                          break;
                        case "bottom":
                          v = "0.75";
                          break;
                      }
                      if (h != "0.5" || v != "0.5") {
                        itemsExport += "<XYJustification 1> <XY " + h + ", " + v + "> ";
                      }
                      if (stim[j].format != "text") {
                        itemsExport += "<" + stim[j].format + "> ";
                      }
                    }
                    itemsExport += "\"" + stim[j].val + "\"";
                    break;
                  case "wav":
                    switch (stim[j].horizontal.toLowerCase()) {
                      case "left":
                        h = "0";
                        break;
                      case "both":
                        h = "2";
                        break;
                      case "right":
                        h = "1";
                        break;
                    }
                    if (stim[j].syncText.toLowerCase() == "true") {
                      itemsExport += "<FrameDuration 0> <SetVisualProbe start> ";
                    } else {
                      if (self.parameters.frameduration() != stim[j].duration) {
                        itemsExport += "<FrameDuration " + stim[j].duration + "> ";
                      }
                    }
                    itemsExport += "<wav " + h + "> ";
                    itemsExport += "\"" + stim[j].val + "\"";
                    break;
                }
                if (stim[j].clear.toLowerCase() == "true") {
                  itemsExport += " / ";
                } else {
                  if (j + 1 < stim.length) {
                    itemsExport += " /! ";
                  }
                }
              }
              itemsExport += "; \n"; 
            }
            break;
          case "loop":
            break;
        }
      }
    } else {
      // Parameters options...
      parametersExport += "<ep> ";
      parametersExport += "<t " + self.parameters.timeout() + "> ";
      parametersExport += "<d " + self.parameters.delay() + "> ";
      parametersExport += "<dfd " + self.parameters.frameduration() + "> ";
      if (self.parameters.keyboard() == "true") {
        parametersExport += "<id keyboard> ";
      }
      if (self.parameters.mouse() == "true") {
        parametersExport += "<id mouse> ";
      }
      if (self.parameters.PIO12() == "true") {
        parametersExport += "<id PIO12> ";
      }
      if (self.parameters.digitalvox() == "true") {
        parametersExport += "<id digitalvox> ";
      }
      if (self.parameters.recordvocal() == "true") {
        parametersExport += "<id recordvocal> ";
      }
      parametersExport += "<vm " + self.parameters.videomode.width() + ", " + self.parameters.videomode.height() + ", " + self.parameters.videomode.realheight() + ", " + self.parameters.videomode.bpp() + ", " + self.parameters.videomode.hz() + "> ";
      switch (self.parameters.feedback()) {
        case "none": 
          parametersExport += "<nfb> ";
          break;
        case "outcome": 
          parametersExport += "<nfbt> ";
          break;
        case "outcome and rt": 
          parametersExport += "";
          break;
      }
      if (self.parameters.continuosrun() == "true") {
        parametersExport += "<cr> ";
      }
      parametersExport += "<dwc " + self.hexToKilo(self.parameters.color()) + "> ";
      parametersExport += "<dbc " + self.hexToKilo(self.parameters.bgcolor()) + "> ";
      parametersExport += "<dfs " + self.parameters.fontsize() + "> ";
      if (self.parameters.outputascii() == "true") {
        parametersExport += "<azk> ";
      }
      if (self.parameters.recordclockontime() == "true") {
        parametersExport += "<rcot> ";
      }

      parametersExport += "\n<! -------------------------------------------------- >\n";
      parametersExport += "<! Experiment: " + self.description() + ">\n";
      parametersExport += "<! Created using Visual DMDX: ";
      parametersExport += "http://visualdmdx.com/edit/" + self.id + " >\n";
      parametersExport += "<! -------------------------------------------------- >\n";
      parametersExport += "<eop>\n"

      // Items...

      for (i = 0; i < it.length; i++) {
        switch (it[i].type.toLowerCase()) {
          case "instructions":
            itemsExport += "00 ";
            lines = it[i].content.split(/\r|\r\n|\n/);
            if (lines.length > 1) {
              l = Math.round(lines.length/2);
              itemsExport += "<ln " + (-1*l+1) + "> \"" + lines[0] + "\"";
              for (j = 1; j < lines.length; j++) {
                itemsExport += ", \n    <ln " + (j-l+1) + "> \"" + lines[j] + "\"";
              }
            } else {
              itemsExport += "\"" + lines[0] + "\"";
            }
            itemsExport += "; \n"; 
            break;
          case "item":
            stim = it[i].stimuli;
            if (stim.length > 0) {
              switch (it[i].response.toLowerCase()) {
                case "positive":
                  itemsExport += "+";
                  break;
                case "negative":
                  itemsExport += "-";
                  break;
                case "no-response":
                  itemsExport += "^";
                  break;
                case "any":
                  itemsExport += "=";
                  break;
              }
              itemsExport += (i+1) + " ";
              for (j = 0; j < stim.length; j++) {
                if (it[i].clockon == j + 1) {
                  itemsExport += "* ";
                }
                switch (stim[j].format.toLowerCase()) {
                  case "blank":
                    if (self.parameters.frameduration() != stim[j].duration) {
                      itemsExport += "<% " + stim[j].duration + "> ";
                    }
                    break;
                  case "text":
                  case "bmp":
                  case "jpg":
                  case "dv":
                    if (self.parameters.frameduration() != stim[j].duration) {
                      itemsExport += "<% " + stim[j].duration + "> ";
                    }
                    if (stim[j].fullScreen.toLowerCase() == "true") {
                      if (stim[j].format.toLowerCase() != "text") {
                        itemsExport += "<" + stim[j].format + " 0, 0, 0, 0> ";
                      }
                    } else {
                      switch (stim[j].horizontal.toLowerCase()) {
                        case "left":
                          h = "0.25";
                          break;
                        case "center":
                          h = "0.5";
                          break;
                        case "right":
                          h = "0.75";
                          break;
                      }
                      switch (stim[j].vertical.toLowerCase()) {
                        case "top":
                          v = "0.25";
                          break;
                        case "middle":
                          v = "0.5";
                          break;
                        case "bottom":
                          v = "0.75";
                          break;
                      }
                      if (h != "0.5" || v != "0.5") {
                        itemsExport += "<XYJustification 1> <XY " + h + ", " + v + "> ";
                      }
                      if (stim[j].format.toLowerCase() != "text") {
                        itemsExport += "<" + stim[j].format + "> ";
                      }
                    }
                    itemsExport += "\"" + stim[j].val + "\"";
                    break;
                  case "wav":
                    switch (stim[j].horizontal.toLowerCase()) {
                      case "left":
                        h = "0";
                        break;
                      case "both":
                        h = "2";
                        break;
                      case "right":
                        h = "1";
                        break;
                    }
                    if (stim[j].syncText.toLowerCase() == "true") {
                      itemsExport += "<% 0> <svp start> ";
                    } else {
                      if (self.parameters.frameduration() != stim[j].duration) {
                        itemsExport += "<% " + stim[j].duration + "> ";
                      }
                    }
                    itemsExport += "<wav " + h + "> ";
                    itemsExport += "\"" + stim[j].val + "\"";
                    break;
                }
                if (stim[j].clear.toLowerCase() == "true") {
                  itemsExport += " / ";
                } else {
                  if (j + 1 < stim.length) {
                    itemsExport += " /! ";
                  }
                }
              }
            itemsExport += "; \n"; 
            }
            break;
          case "loop":
            break;
        }
      }
    }

    self.lastExport(parametersExport + itemsExport);
  };

  self.exportToJSON = function() {
    var clone = (JSON.parse(JSON.stringify(ko.toJS(self)))),
        i, j;

    delete clone.lastExport;
    delete clone.verbose;

    for(i = 0; i < clone.items.length; i++) {
      delete clone.items[i].show;
      for(j = 0; j < clone.items[i].stimuli.length; j++) {
        delete clone.items[i].stimuli[j].show;
      }
    }

    self.lastExport(JSON.stringify(ko.toJS(clone), null, 2));
  };

  self.importFromJSON = function() {
    var someJSON = $("#fromjson").val(),
        parsed,
        mappedItems,
        importbtn,
        nPars = 0,
        nItems = 0;

    if (someJSON) {
      parsed = JSON.parse(someJSON);
      if (parsed) {
        if (parsed.description) {
          self.description(parsed.description);
          nPars++;
        }
        if (parsed.parameters.timeout) {
          self.parameters.timeout(parsed.parameters.timeout);
          nPars++;
        }
        if (parsed.parameters.keyboard) {
          self.parameters.keyboard(parsed.parameters.keyboard);
          nPars++;
        }
        if (parsed.parameters.mouse) {
          self.parameters.mouse(parsed.parameters.mouse);
          nPars++;
        }
        if (parsed.parameters.PIO12) {
          self.parameters.PIO12(parsed.parameters.PIO12);
          nPars++;
        }
        if (parsed.parameters.digitalvox) {
          self.parameters.digitalvox(parsed.parameters.digitalvox);
          nPars++;
        }
        if (parsed.parameters.recordvocal) {
          self.parameters.recordvocal(parsed.parameters.recordvocal);
          nPars++;
        }
        if (parsed.parameters.videomode.width) {
          self.parameters.videomode.width(parsed.parameters.videomode.width);
          nPars++;
        }
        if (parsed.parameters.videomode.height) {
          self.parameters.videomode.height(parsed.parameters.videomode.height);
          nPars++;
        }
        if (parsed.parameters.videomode.realheight) {
          self.parameters.videomode.realheight(parsed.parameters.videomode.realheight);
          nPars++;
        }
        if (parsed.parameters.videomode.bpp) {
          self.parameters.videomode.bpp(parsed.parameters.videomode.bpp);
          nPars++;
        }
        if (parsed.parameters.videomode.hz) {
          self.parameters.videomode.hz(parsed.parameters.videomode.hz);
          nPars++;
        }
        if (parsed.parameters.feedback) {
          self.parameters.feedback(parsed.parameters.feedback);
          nPars++;
        }
        if (parsed.parameters.frameduration) {
          self.parameters.frameduration(parsed.parameters.frameduration);
          nPars++;
        }
        if (parsed.parameters.delay) {
          self.parameters.delay(parsed.parameters.delay);
          nPars++;
        }
        if (parsed.parameters.continuosrun) {
          self.parameters.continuosrun(parsed.parameters.continuosrun);
          nPars++;
        }
        if (parsed.parameters.color) {
          self.parameters.color(parsed.parameters.color);
          nPars++;
        }
        if (parsed.parameters.bgcolor) {
          self.parameters.bgcolor(parsed.parameters.bgcolor);
          nPars++;
        }
        if (parsed.parameters.fontsize) {
          self.parameters.fontsize(parsed.parameters.fontsize);
          nPars++;
        }
        if (parsed.parameters.outputascii) {
          self.parameters.outputascii(parsed.parameters.outputascii);
          nPars++;
        }
        if (parsed.parameters.recordclockontime) {
          self.parameters.recordclockontime(parsed.parameters.recordclockontime);
          nPars++;
        }
        if (parsed.items) {
          mappedItems = $.map(parsed.items, function(item) { return new Item(item) });
          self.items(mappedItems);
          nItems = mappedItems.length;
        }

        importbtn = $("#importbutton");
        importbtn.attr("data-content", nPars + " parameters and " + nItems + " items imported");
      }
    }
  };

  self.dumpFrames = function(item) {
    var instf = 120,
        dump = [];

    switch (item.type) {
      case "instructions":
        dump.push({ text: item.content, duration: instf});
        break;
      case "item":
        stim = item.stimuli;
        for (j = 0; j < stim.length; j++) {
          switch (stim[j].format) {
            case "blank":
              dump.push({ text: "", duration: stim[j].duration});
              break;
            case "text":
              dump.push({ text: stim[j].val, duration: stim[j].duration});
              break;
            case "bmp":
            case "jpg":
            case "wav":
              dump.push({ text: stim[j].val + "." + stim[j].format, duration: stim[j].duration});
              break;
          }
        }
        break;
      case "loop":
        dump.push({ text: item.description, duration: item.content});
        break;
    }

    return dump;
  };

  self.evalVariables = function(items, variables, index) {
    var evaled = items.slice(),
        json,
        re,
        i, 
        j;

    for (i = 0; i < evaled.length; i++) {
      json = JSON.stringify(evaled[i]);
      for (j = 0; j < variables.length; j++) {
        re = new RegExp("\\[" + variables[j].name + "\\]", "g");
        json = json.replace(re, variables[j].values[index].v);
        evaled[i] = JSON.parse(json);
      }
    }

    return evaled;
  };

  self.unrollLoops = function(items) {
    var unrolled = [],
        aux = [],
        auxEval = [],
        i,
        j;

    for (i = 0; i < items.length; i++) {
      if (items[i].type == "loop") {
        // Unroll...
        aux = items.slice(i + 1, i + items[i].content + 1);
        if (items[i].scramble == "true") {
          aux.unshift("scramble"); // Insert "scramble" pseudo-item, used by scrambleItems
        }
        aux = self.unrollLoops(aux);
        for (j = 0; j < items[i].description; j++) {
          auxEval = self.evalVariables(aux, items[i].variables, j);
          unrolled.push(auxEval);
        }
        i += items[i].content;
      } else {
        unrolled.push(items[i]);
      }
    }

    return unrolled;
  };

  self.flattenArray = function (arr) {
    var flat = Array.prototype.concat.apply([], arr);

    if (flat.length != arr.length) {
      flat = self.flattenArray(flat);
    }

    return flat;
  };

  self.fisherYates = function (arr) {
    var i = arr.length,
        j,
        tempi,
        tempj;

    if (i == 0) return false;

    while (--i) {
      j = Math.floor(Math.random() * (i + 1));
      tempi = arr[i];
      tempj = arr[j];
      arr[i] = tempj;
      arr[j] = tempi;
    }
  };

  self.scrambleItems = function(items) {
    var scrambled = [],
        aux = [],
        i = 0,
        j = 0;

    if (items[0] == "scramble") {
      aux = items.slice(1); // remove "scramble" pseudo-item
      self.fisherYates(aux); // Scramble!
    } else {
      aux = aux.concat(items)
    }

    for (i = 0; i < aux.length; i++) {
      if ($.isArray(aux[i])) {
        scrambled.push(self.scrambleItems(aux[i]));
      } else {
        scrambled.push(aux[i]);
      }
    }

    return scrambled;
  };

  self.unrollItems = function() {
    var it = ko.toJS(self.items),
        itrel = [],
        unroll = [],
        scrambled = [],
        flatten = [],
        nloops = 0,
        i = 0;

    // Convert loops' absolute refs to relative refs
    for (i = 0; i < it.length; i++) {
      if (it[i].type == "loop") {
        it[i].content = it[i].content - i - 1;
        itrel.push(it[i]);
        nloops++;
      } else {
        itrel.push(it[i]);
      }
    }

    if (nloops > 0) {
      unroll = self.unrollLoops(itrel);
      scrambled = self.scrambleItems(unroll);
      flatten = self.flattenArray(scrambled);
    } else {
      flatten = it.slice();
    }

    return flatten;
  };

  self.createPreview = function() {
    var i = 0,
        j = 0,
        unrolled = self.unrollItems(),
        frames = [],
        sum = 0,
        fd = 17,
        previewBtn = $("#previewbutton");

    // Disable button
    $("#previewbutton").prop("disabled", true);

    // Dump frames
    for (i = 0; i < unrolled.length; i++) {
      frames = frames.concat(self.dumpFrames(unrolled[i]));
    }

    // Calculate offsets and set timers
    for (i = 0; i < frames.length; i++) {
      frames[i].offset = sum;
      sum += parseInt(frames[i].duration);
      window.setTimeout(function (text) {
          return function() { drawFrame(text) }
        } (frames[i].text), 
        frames[i].offset * fd
      );
    }

    // Enable button
    if (frames[frames.length-1]) {
      previewBtn.attr("data-content", frames.length + " frames generated");
      window.setTimeout(function () {
        $("#previewbutton").prop("disabled", false).popover('hide');
        drawFrame("");
      }, 1000 + frames[frames.length-1].offset * fd);
    } else {
      previewBtn.attr("data-content", "There are no frames to generate");
      $("#previewbutton").prop("disabled", false);
    }

  };

};

drawFrame = function(text) {
  $("#previewdump").text(text);
}

$(document).ready(function() {
  var model = new DMDXModel(initialData),
      i = initialData.version,
      url = '/edit/' + initialData.id + '/';

  ko.applyBindings(model);

  $(".pick-a-color").pickAColor({
    showSpectrum: true,
    showSavedColors: false,
    saveColorsPerElement: false,
    fadeMenuToggle: true,
    showAdvanced: false,
    showHexInput: true,
    showBasicColors: true
  });

  $("#editproject").click(function() {
    var id = $("#projectid").val(),
        url = "/edit/" + id;
    $(location).attr('href',url);
  });

  for (; i >= 0; i--) {
    $("#versionslinks").append('<li><a href="' + url + i + '"><span class="glyphicon glyphicon-cloud-download"></span> Version ' + i + '</a></li>');
  }

  $('.popover-link').popover();

  $(':not(#anything)').on('click', function (e) {
    $('.popover-link').each(function () {
      //the 'is' for buttons that trigger popups
      //the 'has' for icons and other elements within a button that triggers a popup
      if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
        $(this).popover('hide');
        return;
      }
    });
  });

});

