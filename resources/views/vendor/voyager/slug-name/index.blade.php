@extends('voyager::master')

@section('content')
<title>My App</title>
<!-- Include Vuetify CSS -->
<link href="https://cdn.jsdelivr.net/npm/vuetify@2.6.1/dist/vuetify.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js">
<link href="https://cdn.jsdelivr.net/npm/vuetify@2.6.1/dist/vuetify.min.js">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.9.55/css/materialdesignicons.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div id="app">
    <!-- Vue.js code with Vuetify components -->
    <div id="app">
      <!-- Vue.js code with Vuetify components -->
      <template>
        <v-bottom-navigation
          v-model="value"
          :background-color="color"
          dark
          shift
        >

          <v-btn @click="handleA1Click">
            <span>A1</span>
            <v-icon>mdi-telegram</v-icon>
          </v-btn>

          <v-btn>
            <span>A2</span>
            <v-icon>telegram</v-icon>
          </v-btn>

          <v-btn>
            <span>A3</span>
            <v-icon>telegram</v-icon>
          </v-btn>

          <v-btn>
            <span>C1</span>
            <v-icon>telegram</v-icon>
          </v-btn>
        </v-bottom-navigation>
      </template>
  </div>

  <div v-if="showComponent">
    <h6>5555</h6>
  </div>
<!-- Include Vue.js and Vuetify JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.6.1/dist/vuetify.min.js"></script>

<!-- Include your Vue.js code -->
<script>
Vue.use(Vuetify);

new Vue({
   el: '#app',
   vuetify: new Vuetify({
      icons: {
         iconfont: 'mdi',
      },
   }),
   data: () => ({
      value: 1,
      colors: ['blue-grey', 'teal', 'brown', 'indigo'],
      showComponent: false
   }),
   computed: {
      color() {
         return this.colors[this.value] || 'blue-grey';
      },
   },
   methods: {
    handleA1Click() {
      this.showComponent = true;
      console.log('ddd',this.showComponent);
    }

   },
});
</script>
</body>
@endsection
