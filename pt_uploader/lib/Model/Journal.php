<?php
namespace MyApp\Model;

class Journal extends \MyApp\Model{
    // データベース情報は$pdoに格納されている
    
    public function findAll(){
        // id順にJournalテーブルの情報をすべて取得し返すメソッド
        $stmt = $this->db->query("select * from journal order by id");
        // query:ユーザーからの入力情報を利用しない場合prepareよりこっちの方がスマート

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
        // FETCH_CLASSでは$stmt(stdClass)のプロパティとしてデータを格納できるためスマート
    }

    public function findId($values){
        $stmt = $this->db->prepare("SELECT * from journal where id = :id");
        $stmt->bindValue(':id',$values,\PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();

    }

    public function delete($values){
        $stmt = $this->db->prepare(
            'DELETE FROM journal WHERE id = :id'
        );
        $res = $stmt->execute([
            ':id' => $values['id']
            ]);
    }

    public function update($values){
        $stmt = $this->db->prepare(
            "UPDATE journal 
            SET    title = :title,
                    presenter = :presenter, 
                    abstract = :abstract, 
                    keyword1 = :keyword1, 
                    keyword2 = :keyword2, 
                    keyword3 = :keyword3, 
                    maintext = :maintext
            where id = :id"
        );
        $res = $stmt->execute([
            ':id' => $values['id'],
            ':title' => $values['title'],
            ':presenter' => $values['presenter'],
            ':abstract' => $values['abstract'],
            ':keyword1' => $values['keyword1'],
            ':keyword2' => $values['keyword2'],
            ':keyword3' => $values['keyword3'],
            ':maintext' => $values['maintext']
            ]);
            if($res === false){
                throw new \MyApp\Exception\DuplicateJournal();
            }
    }

    public function create($values){
            // prepare:変数の受付準備（変数を使用しない場合query()を使う）
            // Postされた情報をデータベースに保存   
            // insert            
            $stmt = $this->db->prepare(
                "INSERT INTO journal 
            (title,presenter,abstract,keyword1,keyword2,keyword3,maintext,created,modified)
            VALUES (:title, :presenter, :abstract, :keyword1, :keyword2, :keyword3, :maintext, now(), now())");
            // bind：変数をSQL文に挿入 excecute:SQL実行
            $res = $stmt->execute([
            ':title' => $values['title'],
            ':presenter' => $values['presenter'],
            ':abstract' => $values['abstract'],
            ':keyword1' => $values['keyword1'],
            ':keyword2' => $values['keyword2'],
            ':keyword3' => $values['keyword3'],
            ':maintext' => $values['maintext']
            ]);
            if($res === false){
                throw new \MyApp\Exception\DuplicateJournal();
            // 二重投稿防止のためpresenter以外のカラムはUnique属性なので重複するとfalseとなる
            }
        }
}
