-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: custsql-pow13
-- Generation Time: Jan 31, 2017 at 05:24 PM
-- Server version: 5.6.32
-- PHP Version: 4.4.9
-- 
-- Database: `superbowl_51`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `VNSB_settings`
-- 

CREATE TABLE `VNSB_settings` (
  `sb_date` varchar(30) NOT NULL DEFAULT '',
  `sb_logo` varchar(30) DEFAULT NULL,
  `NFC_team` varchar(30) DEFAULT NULL,
  `NFC_logo` varchar(80) DEFAULT NULL,
  `AFC_team` varchar(30) DEFAULT NULL,
  `AFC_logo` varchar(80) DEFAULT NULL,
  `Bet` varchar(5) NOT NULL DEFAULT '5.00',
  `Win_first` tinyint(2) NOT NULL DEFAULT '20',
  `Win_second` tinyint(2) NOT NULL DEFAULT '25',
  `Win_third` tinyint(2) NOT NULL DEFAULT '20',
  `Win_final` tinyint(2) NOT NULL DEFAULT '35',
  `Version` char(3) NOT NULL DEFAULT '',
  `Admin_email` varchar(30) NOT NULL DEFAULT 'admin@email.com',
  `Admin_pwd` varchar(8) NOT NULL DEFAULT 'password',
  PRIMARY KEY (`sb_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Setting for VN SuperBowl Squares';

-- 
-- Dumping data for table `VNSB_settings`
-- 

INSERT INTO `VNSB_settings` VALUES ('February 5, 2017', 'sb_logo.png', 'Falcons', '/VNSB_releases/NFL_logos/Atlanta_Falcons.gif', 'Patriots', '/VNSB_releases/NFL_logos/NewEngland_Patriots.gif', '5.00', 20, 25, 20, 35, '4.2', 'admin@vnlisting.com', 'iloveu29');
