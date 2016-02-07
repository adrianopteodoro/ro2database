var charSex = {
    '0': 'Sem restrição',
    '1': 'Masculino',
    '2': 'Feminino',
    '3': 'Ambos'
};

var classNames = {
    '0': 'Todas',
    '32': 'Guerreiro',
    '64': 'Cavaleiro',
    '97': 'Espadachim',
    '128': 'Bruxo',
    '256': 'Feiticeiro',
    '386': 'Mago',
    '512': 'Ranger',
    '1024': 'Beastmaster',
    '1540': 'Arqueiro',
    '2048': 'Mercenario',
    '4096': 'Arruaceiro',
    '6152': 'Gatuno',
    '8192': 'Sarcedote',
    '16384': 'Monge',
    '24592': 'Noviço'
};

function itemsPage() {
    $('#content').html("");
    $('#content').append("<div id='itemlistoptions'></div>");
    $('#content').find("#itemlistoptions").append("<form id='itemsform' action='javascript:void(0);' method='get'></form>");
    $('#content').find("#itemsform").append("<span>Classe:</span><input class='classes' list='classlist'>");
    $('#content').find("#itemsform").append("<datalist id='classlist'></datalist>");
    $('#content').find("#itemsform").append("<input class='button' type='submit'>");

    $.each(classNames, function (index, value) {
        $('#content').find("#classlist").append("<option id='" + index + "' value='" + value + "'>");
    });

    $('#content').append('<br style="clear: both;" />');
}

function getItems(classe, start, count) {
    var total = 0;
    var pagecount = 0;
    $.getJSON('json.php?get=itemcount&classe=' + classe, function (ic) {
        $.each(ic, function (key, val) {
            total = val['total'];
        });
    });


    $.getJSON('json.php?get=item&classe=' + classe + '&start=' + start + '&count=' + count, function (data) {
        var items = [];
        $.each(data, function (key, val) {
            if (val['ID'] !== null) {
                var line = $('<li/>').append($('<li/>', {'id': 'item-' + key}));
                line.find('#item-' + key).append($('<img/>', {'class': 'icon'}), $('<div/>', {'class': 'info'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'name'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'reqjob'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'reqlvl'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'reqsex'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'price'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'candrop'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'candeposit'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'candestruct'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'cansell'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'cantrade'}));
                line.find('#item-' + key + ' .info').append($('<span/>', {'class': 'cancompose'}));
                line.find('#item-' + key + ' .info').append('<a href="javascript:void(0);" class="button">Ver Mais</a>');
                $.each(val, function (k, v) {
                    switch (k) {
                        case 'Name':
                            line.find('.name').html(v);
                            break;
                        case 'Grade':
                            //line.find('.name').append('&nbsp;<span>' + v + '</span>');
                            switch (v) {
                                case '1':
                                    line.find('.name').addClass('normal');
                                    break;
                                case '2':
                                    line.find('.name').addClass('green');
                                    break;
                                case '3':
                                    line.find('.name').addClass('blue');
                                    break;
                                case '4':
                                    line.find('.name').addClass('purple');
                                    break;
                                default:
                                    line.find('.name').addClass('normal');
                                    break;
                            }
                            break;
                        case 'Icon':
                            line.find('.icon').attr('src', v);
                            break;
                        case 'Require_Job':
                            line.find('.reqjob').html('<b>Classe:</b> ' + getiReqJob(v));
                            break;
                        case 'Require_Level':
                            line.find('.reqlvl').html('<b>Lvl:</b> ' + getiLvl(v));
                            break;
                        case 'Require_Sex':
                            line.find('.reqsex').html('<b>Sexo:</b> ' + getiReqSex(v));
                            break;
                        case 'Price_Buy':
                            line.find('.price').html('<b>Preço:</b> ' + getiPrice(v));
                            break;
                        case 'Is_Drop':
                            line.find('.candrop').html('<b>Pode dropar:</b> ' + (v ? 'Sim' : 'Não'));
                            break;
                        case 'Is_Deposit':
                            line.find('.candeposit').html('<b>Pode depositar:</b> ' + (v ? 'Sim' : 'Não'));
                            break;
                        case 'Is_Destruct':
                            line.find('.candestruct').html('<b>Pode destruir:</b> ' + (v ? 'Sim' : 'Não'));
                            break;
                        case 'Is_Sell':
                            line.find('.cansell').html('<b>Pode vender:</b> ' + (v ? 'Sim' : 'Não'));
                            break;
                        case 'Is_Trade':
                            line.find('.cantrade').html('<b>Pode trocar:</b> ' + (v ? 'Sim' : 'Não'));
                            break;
                        case 'Is_Compose':
                            line.find('.cancompose').html('<b>Pode compor:</b> ' + (v ? 'Sim' : 'Não'));
                            break;
                    }
                });
                items.push(line.html());
            }
        });
        itemsPage();
        $('<ul/>', {html: items.join(''), 'id': 'itemlist'}).appendTo('#content');
        $('#content').append('<br style="clear: both;" />');
        // Pagination
        var pages = $('<div/>').append($('<div/>', {'id': 'pagination'}));
        pages.find('#pagination').append($('<div/>', {'id': 'back'}));
        pages.find('#pagination').append($('<div/>', {'id': 'pages'}));
        pages.find('#pagination').append($('<div/>', {'id': 'next'}));

        // Pages
        var apage =  Math.round((count + start) / count);
        var i = 0;
        pagecount = total / count;
        pagecount = Math.round(pagecount);
        if (apage !== 1) {
            pages.find('#pages').append("<a id=\"first_page\" href=\"javascript:void(0);\" class=\"button\" onClick=\"window.getItems(" + classe + ", 0, " + count + ");\">1</a>");
            if ((apage - 4) > 1) {
                pages.find('#pages').append("<span id=\"page\" class=\"button\">. . .</span>");
            }
        }
        if (apage > 1) {
            for (i = (apage - 4); i < apage; i++) {
                if (i > 1) {
                    pages.find('#pages').append("<a id=\"page\" href=\"javascript:void(0);\" class=\"button\" onClick=\"window.getItems(" + classe + ", " + ((i * 5) - 5) + ", " + count + ");\">" + i + "</a>");
                }
            }
        }
        pages.find('#pages').append("<span id=\"page_actual\" class=\"button\">" + apage + "</span>");
        if (apage < pagecount) {
            for (i = (apage + 1); i < (apage + 5); i++) {
                if (i < pagecount) {
                    pages.find('#pages').append("<a id=\"page\" href=\"javascript:void(0);\" class=\"button\" onClick=\"window.getItems(" + classe + ", " + ((i * 5) - 5) + ", " + count + ");\">" + i + "</a>");
                }
            }
        }
        if (apage !== pagecount) {
            if ((apage + 4) < pagecount) {
                pages.find('#pages').append("<span id=\"page\" class=\"button\">. . .</span>");
            }
            pages.find('#pages').append("<a id=\"last_page\" href=\"javascript:void(0);\" class=\"button\" onClick=\"window.getItems(" + classe + ", " + (total - count) + ", " + count + ");\">" + pagecount + "</a>");
        }

        if (start > 0) {
            pages.find('#back').append('<a class="button" href="javascript:void(0);" onClick="window.getItems(' + classe + ', ' + (start - count) + ', ' + count + ');"><< Anterior</a>');
        }
        if (total > (start + count)) {
            pages.find('#next').append('<a class="button" href="javascript:void(0);" onClick="window.getItems(' + classe + ', ' + (start + count) + ', ' + count + ');">Próxima >></a>');
        }
        $('#content').append(pages.html());
        $('#content').append('<br style="clear: both;" />');
    });
}

function getiPrice(id) {
    return ((id > 999) ? id.substr(0, id.length - 3) + 'z ' : '') + ((id.substr(id.length - 3) !== 0) ? id.substr(id.length - 3) + 'r' : '0r');
}

function getiReqSex(id) {
    var ret = id;
    $.each(charSex, function (i, v) {
        if (id == i) {
            ret = v;
        }
    });
    return ret;
}

function getiReqJob(id) {
    var ret = id;
    $.each(classNames, function (i, v) {
        if (id == i) {
            ret = v;
        }
    });
    return ret;
}

function getiLvl(lv) {
    var ret = lv;
    if (lv == 0) {
        ret = 'Sem restrição';
    }
    return ret;
}