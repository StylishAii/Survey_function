# SANGO Gutenberg plugin

This project was bootstrapped with [Create Guten Block](https://github.com/ahmadawais/create-guten-block).

## `npm start`

- Use to compile and run the block in development mode.

## `npm run build`

- Use to build production code for your block inside `dist` folder.
- Runs once and reports back the gzip file sizes of the produced code.

### `gulp create-zip`

- Create a zip file that works as a plugin and is hosted on Netfliy.

## How to release

1. sango-theme-gutenberg.phpのバージョン番号を書き換え（2箇所）
2. netlify/update-info.jsonのバージョン番号を書き換え
3. `npm run build`
4. `gulp create-to-zip`
   (note that you must use gulp-zip@3.0.2 If not, the archive file will not be read correctly on WP.)
5. 手動で`./netlify/sango-theme-gutenberg`をzip圧縮する (gulp-zipがうまく動かないため)
6. リリースノートを書く
7. GitHubにプッシュ
8. masterブランチにマージ
9. => 自動でNetlifyにzipファイルがホスティング
