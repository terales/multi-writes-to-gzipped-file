## This is a [research code](https://meiert.com/en/blog/20140716/research-and-production/).

# Multiple writes to the same `xml` file with `compress.zlib://` stream would fail to decode in browsers

#### Chrome, v60:

![image](https://user-images.githubusercontent.com/1920639/29138081-2c8890f4-7d4b-11e7-8162-a0b625f6df43.png)

#### Firefox, v54:

![image](https://user-images.githubusercontent.com/1920639/29138131-5a70c842-7d4b-11e7-9ebf-d484e4fe3b5b.png)

### How to reproduce

Sample files could be generated in `generate-files.php` and served via `serve.php`. 

How to check this issue?

```sh
composer start-server

# in the other terminal
composer check
```

Try how different files served:

* http://localhost:8000/serve.php?file=multi
* http://localhost:8000/serve.php?file=remulti
* http://localhost:8000/serve.php?file=one