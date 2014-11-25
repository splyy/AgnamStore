/*==============================================================*/
/* Insert Table : Type                                          */
/*==============================================================*/
insert into item_type values(1, "Manga");
insert into item_type values(2, "Anime");
insert into item_type values(3, "Light Novel");
insert into item_type values(4, "Film");

/*==============================================================*/
/* Insert Table : Genre                                         */
/*==============================================================*/
insert into item_genre values("FT", "Fantasy");
insert into item_genre values("HO", "Horreur");
insert into item_genre values("SC", "Scolaire");
insert into item_genre values("AV", "Aventure");
insert into item_genre values("SF", "Science Fiction");
insert into item_genre values("PO", "Policier");
insert into item_genre values("DR", "Dramatique");
insert into item_genre values("HU", "Humoristique");
insert into item_genre values("HS", "Historique");

/*==============================================================*/
/* Insert Table : Item                                          */
/*==============================================================*/

/* ANIME*/
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Hunter X Hunter", "", 2011, "Yoshihiro Togashi", "BLABLA", 19.99, "a_img_hxh.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Fairy Tail", "", 2011, "Hiro Mashima", "BLABLA", 19.99, "a_img_ft.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Naruto", "", 2011, "blabla", "blabla", 19.99, "a_img_naruto.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Elfen Lied", "", 2002, "Lynn Okamoto", "BLABLA", 19.99, "a_img_elfen.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Gantz", "", 2000, "Hiroya Oku", "BLABLA", 19.99, "a_img_gantz.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("School Rumble", "", 2003, "Jin Kobayashi", "BLABLA", 19.99, "a_img_rumble.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("GTO", "", 1997, "Toru Fujisawa", "BLABLA", 19.99, "a_img_gto.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Hikaru No Go", "", 1998, "Yumi Hotta", "BLABLA", 19.99, "a_img_hikaru.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Zipang", "", 2000, "", "BLABLA", 19.99, "a_img_zipang.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Gurren Lagann", "", 2007, "Hiroyuki Imaishi", "BLABLA", 19.99, "a_img_gurren.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Ranma 1/2", "", 1987, "Rumiko Takahashi", "BLABLA", 19.99, "a_img_ranma.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Angel Beats", "", 2009, "Jun Maeda", "BLABLA", 19.99, "a_img_angel.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("RahXephon", "", 2002, "Yutaka Izubuchi", "BLABLA", 19.99, "a_img_rah.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Death Note", "", 2003, "Tsugumi Oba", "BLABLA", 19.99, "a_img_death.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Nicky Larson", "", 1987, "Kenji Kodama", "BLABLA", 19.99, "a_img_nicky.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Darker than Black", "", 2007, "Tensai Okamura", "BLABLA", 19.99, "a_img_darker.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Ghost in the Shell", "", 1989, "Masamune Shirow", "BLABLA", 19.99, "a_img_ghost.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("One Piece", "", 1997, "Eiichiro Oda", "BLABLA", 19.99, "a_img_piece.png", 2);

/* MANGA */
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Hunter X Hunter", "", 2011, "Yoshihiro Togashi", "BLABLA", 19.99, "m_img_hxh.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Fairy Tail", "", 2011, "Hiro Mashima", "BLABLA", 19.99, "m_img_ft.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Naruto", "", 2011, "blabla", "blabla", 19.99, "m_img_naruto.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Elfen Lied", "", 2011, "Lynn Okamoto", "BLABLA", 19.99, "m_img_elfen.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Gantz", "", 2000, "Hiroya Oku", "BLABLA", 19.99, "m_img_gantz.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("School Rumble", "", 2003, "Jin Kobayashi", "BLABLA", 19.99, "m_img_rumble.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Special A", "", 2003, "Minami Maki", "BLABLA", 19.99, "m_img_special.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Rave", "", 1999, "Hiro Mashima", "BLABLA", 19.99, "m_img_rave.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Cobra", "", 1978, "Buichi Terasawa", "BLABLA", 19.99, "m_img_rumble.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Mobile Suit Gundam Seed", "", 2002, "Mitsuo Fukuda", "BLABLA", 19.99, "m_img_gundam.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Détective Conan", "", 1994, "Gosho Aoyama", "BLABLA", 19.99, "a_img_conan.png", 2);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Bus Gamer", "", 1999, "Kazuya Minekura", "BLABLA", 19.99, "m_img_bus.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Kenshin le vagabond", "", 1994, "Nobuhiro Watsuki", "BLABLA", 19.99, "m_img_kenshin.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Samourai Deeper Kyo", "", 1999, "Akimine Kamijyo", "BLABLA", 19.99, "m_img_kyo.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Pandora Hearts", "", 2006, "Jun Mochizuki", "BLABLA", 19.99, "m_img_pandora.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Vampire Knight", "", 2004, "Matsuri Hino", "BLABLA", 19.99, "m_img_vampire.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Lucky Star", "", 2004, "Kagami Yoshimizu", "BLABLA", 19.99, "m_img_lucky.png", 1);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Ixion Saga DT", "", 2012, "Shinji Takamatsu", "BLABLA", 19.99, "m_img_ixion.png", 1);

/* LIGHT NOVEL */
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Sword art Online", "", 2012, "Reki Kawahara", "BLABLA", 19.99, "l_img_sao.png", 3);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Mahouka Koukou no Rettousei", "Autre nom connu : The Irregular at Magic High School", 2012, "Tsutomu Satou", "BLABLA", 19.99, "l_img_mkr.png", 3);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("All You Need Is Kill", "", 2012, "Hiroshi Sakurazaka", "BLABLA", 19.99, "l_img_aynik.png", 3);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Fate/Zero", "", 2012, "Gen Urobuchi", "BLABLA", 19.99, "l_img_fatezero.png", 3);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Log Horizon", "", 2012, "Mamare Touno", "BLABLA", 19.99, "l_img_loghorizon.png", 3);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Tokyo Ravens", "", 2012, "Kōhei Azano", "BLABLA", 19.99, "l_img_tokyoravens.png", 3);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("No Game No Life", "", 2012, "Kamiya Yuu", "BLABLA", 19.99, "l_img_ngnl.png", 3);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Chrome Shelled Regios", "", 2012, "Shūsuke Amagi", "BLABLA", 19.99, "l_img_csr.png", 3);
/* FILM */
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Hunter X Hunter    The Last Mission", "", 2011, "Yoshihiro Togashi", "BLABLA", 19.99, "f_img_hxh_tlm.png", 4);
insert into item(name, sale_date, year, author, description, price, image, item_type_id) 
	values("Hunter X Hunter    Phantom Rouge", "", 2011, "Yoshihiro Togashi", "BLABLA", 19.99, "f_img_hxh_pr.png", 4);




/*==============================================================*/
/* Insert Table : user                                          */
/*==============================================================*/
INSERT INTO `user` (`user_id`, `user_email`, `user_password`, `user_salt`, `user_role`, `user_firstname`, `user_lastname`, `user_address`, `user_city`, `user_cp`) VALUES(1, 'gory.alexandre02@gmail.com', 'M/aJEwC35IiHsmcx7xLllzEgtDb6QnDs2R8/LDwD4dUrCjRm9s109AWOpLhHQzCEdcpk+R3OTofnnZ7iUm8B1A==', '02b1d0e053a16218e09a3db', 'ROLE_ADMIN', 'Gory', 'Alexandre', '10 rue des alpes', 'Genas', '69740');
INSERT INTO `user` (`user_id`, `user_email`, `user_password`, `user_salt`, `user_role`, `user_firstname`, `user_lastname`, `user_address`, `user_city`, `user_cp`) VALUES(2, 'crepu.alexandre@gmail.com', 'yGxSXwpWWEZvC0Y+3xMc2OU/XhAR5T2dhJcVS6KxsI/8S3EQTEXPA/PDUR2PATLtnx4RwXkEavgehy0rCGMowQ==', '2aa3cacc800e920cc446eba', 'ROLE_USER', 'Crepu', 'Alexandre', '7 rue des kikoo', 'Trevoux', '69XXX');
