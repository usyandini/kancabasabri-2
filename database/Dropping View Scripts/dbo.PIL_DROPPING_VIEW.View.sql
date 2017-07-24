USE [AX_DEV]
GO
/****** Object:  View [dbo].[PIL_DROPPING_VIEW]    Script Date: 24/07/2017 19:46:10 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[PIL_DROPPING_VIEW] AS
SELECT LJT.JOURNALNAME,
       LJT.JOURNALNUM,
	   LJS.TRANSDATE,
	   BAT.ACCOUNTID BANK_DROPPING,
	   BAT.ACCOUNTNUM REKENING_DROPPING,
	   DAVCC.DISPLAYVALUE AKUN_DROPPING,
	   DFT.DESCRIPTION CABANG_DROPPING,
	   LJS.TXT,
	   LJS.AMOUNTCURDEBIT DEBIT,
	   LJS.AMOUNTCURCREDIT KREDIT,
	   LJS.RECID
FROM LEDGERJOURNALTABLE LJT,
     LEDGERJOURNALTRANS LJS,
	 DIMENSIONATTRIBUTEVALUECOMBINATION DAVC,
	 BANKACCOUNTTABLE BAT,
	 DIMENSIONATTRIBUTEVALUECOMBINATION DAVCC,
	 DIMENSIONATTRIBUTEVALUESET DAVS,
	 DIMENSIONATTRIBUTEVALUESETITEM DAVSI,
	 DIMENSIONATTRIBUTEVALUE DAV,
	 DIMENSIONATTRIBUTE DAT,
	 DIMENSIONFINANCIALTAG DFT
WHERE LJT.JOURNALNUM = LJS.JOURNALNUM
AND LJT.JOURNALNAME = 'Dropping'
--AND LJS.JOURNALNUM = 'JB17070095'
AND LJS.ACCOUNTTYPE = 6
AND LJS.LEDGERDIMENSION = DAVC.RECID
AND DAVC.DISPLAYVALUE = BAT.ACCOUNTID
AND BAT.LEDGERDIMENSION =DAVCC.RECID
AND BAT.DEFAULTDIMENSION = DAVS.RECID
AND DAVS.RECID = DAVSI.DIMENSIONATTRIBUTEVALUESET
AND DAVSI.DIMENSIONATTRIBUTEVALUE = DAV.RECID
AND DAV.DIMENSIONATTRIBUTE = DAT.RECID
AND DAT.NAME = 'KPKC'
AND DAV.ENTITYINSTANCE = DFT.RECID
--ORDER BY LJT.JOURNALNUM ASC



GO
