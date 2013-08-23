

function highlightElement(elementId) {
    var t4zi = $('#others').css('z-index');
    var t3zi = $('#act-edit').css('z-index');
    var t2zi = $('#head-edit').css('z-index');
    var t5zi = $('#delete').css('z-index');
   
    if(t4zi == '15') {
        highlightId('#others', elementId);
    }
    else if(t5zi == '15') {
        highlightId('#delete', elementId);
    }
    else if(t3zi == '15') {
        highlightId('#act-edit', elementId);
    }
    else if(t2zi == '15') {
        highlightId('#head-edit', elementId);
    }
    else {
        highlightId('#login-tab', elementId);
    }
    
}

function highlightId(id, eid) {
    var ele;
    switch(eid) {
        case 't5': ele = '#delete';break;
        case 't4': ele = '#others';break;
        case 't3': ele = '#act-edit';break;
        case 't2': ele = '#head-edit';break;
        case 't1': ele = '#login-tab';
    }
    var zi = $(ele).css('z-index');
    $(id).css('z-index', zi);
    $(ele).css('z-index', 15);
    
}