<?php
namespace MyApp\Exception;

class InvalidPassword extends \Exception{
// MyApp(名前空間(libフォルダ))\Exception(サブ名前空間・子フォルダ名)
// 上記名前空間の下にクラス定義をする場合\は必要ないが、基礎クラスなど名前空間の範囲外で
// クラスを定義、継承したい場合は\を付ける

  protected $message = 'Invalid Password';
}
