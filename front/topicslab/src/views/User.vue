<template>
  <div>
    <Card>
      <template #content>
        {{user.name}}<!--なぜかいなくなったユーザー名さん~>帰ってきた-->
      </template>
    </Card>

      <TabView>
        <TabPanel header="トピック">
          <template v-if="user.topics == 0">
            <p>トピックはありません。</p>
          </template>
          <template v-else>
            <Fieldset v-for="topic in user.topics" :key="topic.id"><!--コメントのカード枠-->
            <template #legend>
              <span><!--10変更点-->
                <router-link :to="`/user/${user.id}`">{{user.name}}</router-link>
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
          <template v-if="user.comments == 0">
            <p>コメントはありません。</p>
          </template>
          <Fieldset v-for="comment in user.comments" :key="comment.id"><!--コメントのカード枠-->
          <template #legend>
            <span><!--10変更点-->
              <router-link :to="`/user/${user.id}`">{{user.name}}</router-link>
            </span>
          </template>
          <div>
            <div class="comment-text">
              <!--{{comment.body}}-->
              {{comment.body}}<!--絶対パスだと値が取れるが…うーん????????????????-->
            </div>
          </div>
          </Fieldset>
        </TabPanel>
      </TabView>
  </div>
</template>

<script>
import axios from '@/supports/axios'

export default {
  name: 'user',
  data () {
    return {
      id: null,
      user: {}
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
                this.comments = res.data[5]
                this.topics = res.data.topics
              } else {
                console.log('取得失敗')
              }
            })
            .catch((err) => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  }
}
</script>
