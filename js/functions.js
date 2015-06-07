function itemsPage() {
    $('#content').html("");

    $('#content').append("<div id='itemlistoptions'></div>");
    $('#content').find("#itemlistoptions").append("<form id='itemsform' action='javascript:void(0);' method='get'></form>");
    $('#content').find("#itemsform").append("<span>Classe:</span><input class='classes' list='classlist'>");
    $('#content').find("#itemsform").append("<datalist id='classlist'></datalist>");
    $('#content').find("#itemsform").append("<input class='button' type='submit'>");

    var classes = {'32': 'Guerreiro',
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
            '24592': 'Noviço'};

    $.each(classes, function (index, value) {
        $('#content').find("#classlist").append("<option id='" + index + "' value='" + value + "'>");
    });

    $('#content').append('<br style="clear: both;" />');
}

function getItems(classe, start, count) {
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
                $.each(val, function (k, v) {
                    switch (k)
                    {
                        case 'Name':
                            line.find('.name').html(v);
                            break;
                        case 'Icon':
                            line.find('.icon').attr('src', v);
                            break;
                        case 'Require_Job':
                            line.find('.reqjob').html('<b>Classe:</b> ' + getiReqJob(v));
                            break;
                        case 'Require_Level':
                            line.find('.reqlvl').html('<b>Lvl:</b> ' + v);
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
        var pages = $('<div/>').append($('<div/>', {'id': 'pages'}));
        if (start > 0)
            pages.find('#pages').append('<a id="back" class="button" href="javascript:void(0);" onClick="getItems(' + classe + ', ' + (start - count) + ', ' + count + ');"><< Anterior</a>');
        pages.find('#pages').append('<a id="next" class="button" href="javascript:void(0);" onClick="getItems(' + classe + ', ' + (start + count) + ', ' + count + ');">Próxima >></a>');
        $('#content').append(pages.html());
        $('#content').append('<br style="clear: both;" />');
    });
}

function getiPrice(id) {
    return ((id > 999) ? id.substr(0, id.length - 3) + 'z ' : '') + ((id.substr(id.length - 3) !== 0) ? id.substr(id.length - 3) + 'r' : '0r');
}

function getiReqSex(id) {
    switch (id)
    {
        case '1':
            return 'Masculino';
            break;
        case '2':
            return 'Feminino';
            break;
        case '3':
            return 'Ambos';
            break;
        default:
            return 'N/A';
            break;
    }
}

function getiReqJob(id) {
    switch (id)
    {
        case '32':
            return 'Guerreiro';
            break;
        case '64':
            return 'Cavaleiro';
            break;
        case '97':
            return 'Espadachim';
            break;
        case '128':
            return 'Bruxo';
            break;
        case '256':
            return 'Feiticeiro';
            break;
        case '386':
            return 'Mago';
            break;
        case '512':
            return 'Ranger';
            break;
        case '1024':
            return 'Beastmaster';
            break;
        case '1540':
            return 'Arqueiro';
            break;
        case '2048':
            return 'Mercenario';
            break;
        case '4096':
            return 'Arruaceiro';
            break;
        case '6152':
            return 'Gatuno';
            break;
        case '8192':
            return 'Sarcedote';
            break;
        case '16384':
            return 'Monge';
            break;
        case '24592':
            return 'Noviço';
            break;
        default:
            return 'N/A (' + id + ')';
            break;
    }
}