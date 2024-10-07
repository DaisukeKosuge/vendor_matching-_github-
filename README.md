# ①課題番号-プロダクト名

中小病院ベンダ選定支援アプリ

## ②課題内容（どんな作品か）

- 中小病院のベンダ選定を支援するアプリです。
- 詳細はpdfを参照ください。

## ③DEMO

https://rosary.sakura.ne.jp/vendor_matching/index.php

## ④作ったアプリケーション用のIDまたはPasswordがある場合

病院アカウント
- ID: testA@gmail.com
- PW: testA

ベンダアカウント
- ID: testD@gmail.com
- PW: testD

## ⑤工夫した点・こだわった点

- フィルタリング機能を、複数の条件（提案ジャンル、レビュー点数、ISO取得状況）で行えるように実装しました。具体的には、選択されたフィルタ条件に応じて動的にSQLクエリを構築し、条件に該当するベンダーのみを抽出しています。どの条件も未選択の状態でも動作するように、全てのフィルタはオプションとして扱う設計にしました。
- 下手に見出しの名前等をつけると何が何だかわからなくなるので、まずは簡易的な名前や、簡易的なCSSのみの実装として、これから手を動かしながら色々と変えられるような設計にしています。
- できるだけシームレスになるように設計しています。

## ⑥難しかった点・次回トライしたいこと(又は機能)
- そもそももう少しアプリケーションの企画自体を修正する必要があるとは思ったものの、どう変えるかのアイデアが浮かばずまずは簡単に作ってみて、どうしようか考えようと思っていて、そこが固まっておらず心配です。
- 事前の設計をある程度してから手を動かし始めたが、病院向けのページの作りこみ（フィルタリングとか）を行っただけで提出の起源になってしまっており、全然設計したことを生かせていない。
  また、実際に手を動かしているとここをもっとこうしたい等の修正点が多々あり、予想よりもたくさん時間がかかってしまった。
  病院向けのページは何となく超大枠だけはできたが、ベンダ向けページはまだページとして存在する程度にとどまっているので、病院向けのページをより詳細にしつつ、そちらにも着手したいが、まずは病院向けのページの完成形が想像できるところまでの作りこみを今後行いたい。

## ⑦質問・疑問・感想、シェアしたいこと等なんでも

- [質問]
  実業務では見積提示のために人工だったりを普段から予想しており気になったので質問させてください。
  質問としては、"こういった新しいアプリケーションを作るのに要す時間をどのように推定するのか"になります。
  例えば、○○のアプリに○○という機能を実装するためのコードを記載するためにどれくらい時間を要しそうか？
  であれば経験があれば何となく実績から換算できそうですが、新しいアプリケーションをつくるとなるとコードを描くだけでなく企画・設計もして、さらに全体感をみて都度修正をして、、、
  というようにやることが多岐にわたるかつ、ぶつかってみないとわからないことがたくさんあると今回の課題で小さいながらも思いました。
  こういった開発の進め方として、時間を推定することが重要なのか、重要だとしたらどのように推定するのか、皆様のご経験からご教授いただけますと幸いです。
