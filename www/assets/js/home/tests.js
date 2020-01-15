$('.ui.search')
  .search({
    apiSettings: {
      url: configTranscription['URL'] + '/testsearch?p={query}'
    },
    fields: {
      results : 'items',
      title   : 'name',
      url     : 'id'
    },
    minCharacters : 3
  });