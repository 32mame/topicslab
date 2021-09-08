<template>
  <div>
    <Card>
      <template #content>
        {{user.name}}
        <div>
          <!-- <Textarea v-model="user.description" :autoResize="true" rows="5" /> -->
          {{user.description}}
        </div>
      </template>
    </Card>
      <TabView>
        <TabPanel header="トピック">
          <template v-if="noTopic">
              <p v-if="loaded">トピックはありません。</p> <!--!loadedでfalse-->
              <p v-else>ロード中です。</p>
          </template>
          <template v-else>
            <Fieldset v-for="topic in topics" :key="topic.id"><!--コメントのカード枠-->
            <template #legend>
              <span><!--10変更点-->
                <router-link :to="`/topic/${topic.id}`">トピックへ</router-link>
              </span>
            </template>
            <Card>
            <template #title>
              <router-link :to="`/topic/${topic.id}`"> {{topic.title}} </router-link>
            </template>
            <template #content>
              <div class="body-text">
                {{topic.body}}
              </div>
            </template>
            <template #footer>
              <span>
                <router-link :to="`/user/${user.id}`">{{user.name}}</router-link>
              </span>
            </template>
            </Card>
            </Fieldset>
          </template>
        </TabPanel>
        <TabPanel header="コメント">
          <template v-if="noComment">
              <p v-if="loaded">コメントはありません。</p> <!--!loadedでfalse-->
              <p v-else>ロード中です。</p>
            </template>
            <template v-else>
            <Fieldset v-for="comment in comments" :key="comment.id"><!--コメントのカード枠-->
            <template #legend>
              <span><!--10変更点-->
                <router-link :to="`/topic/${comment.topic_id}`">トピックへ</router-link>
              </span>
            </template>
            <div>
              <div class="comment-text">
                {{comment.body}}
              </div>
            </div>
            </Fieldset>
          </template>
        </TabPanel>
      </TabView>
  </div>
</template>

<script>
import axios from '@/supports/axios'

function alert1 (errmessage) {
  alert(errmessage)
}

export default {
  name: 'user',
  data () {
    return {
      id: null,
      user: {},
      comments: [],
      topics: [],
      loaded: false
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('/login')
      return
    }

    this.id = this.$route.params.id
    if (!this.id) {
      alert('不正なIDです。')
    }
    this.getUser()
  },
  methods: {
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/user/${this.id}`)
            .then((res) => {
              console.log(res)
              if (res.status === 200) {
                this.user = res.data[0]
                this.comments = this.user.comments
                this.topics = this.user.topics
                this.loaded = true
              } else {
                console.log('取得失敗')
              }
            })
            .catch((err) => {
              console.log(err)
              alert1(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  },
  computed: {
    // 算出 getter 関数
    noTopic: function () {
      // `this` は vm インスタンスを指します
      return this.topics.length === 0
    },
    noComment: function () {
      // `this` は vm インスタンスを指します
      return this.comments.length === 0
    }
  }
}
</script>
