USE [PICA_BETA]
GO
/****** Object:  Table [dbo].[unbudget_approval]    Script Date: 01/24/2025 15:23:51 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[unbudget_approval](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[master_id] [bigint] NOT NULL,
	[status] [int] NOT NULL,
	[urutan] [int] NOT NULL,
	[replacing] [bigint] NULL,
	[role] [nvarchar](255) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[NIK] [varchar](20) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[unbudget_atn]    Script Date: 01/24/2025 15:23:51 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[unbudget_atn](
	[KodeST] [nvarchar](255) NOT NULL,
	[current_val] [bigint] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[unbudget_m_coa]    Script Date: 01/24/2025 15:23:51 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[unbudget_m_coa](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[Code_COA] [nvarchar](50) NULL,
	[CoCd] [nvarchar](50) NULL,
	[COA] [nvarchar](255) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[unbudget_master]    Script Date: 01/24/2025 15:23:51 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[unbudget_master](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[NoDocument] [nvarchar](255) NOT NULL,
	[strategi] [nvarchar](max) NULL,
	[ekonomi] [nvarchar](max) NULL,
	[finance] [nvarchar](max) NULL,
	[technology] [nvarchar](max) NULL,
	[operation] [nvarchar](max) NULL,
	[tempat] [nvarchar](255) NULL,
	[KodeST] [nvarchar](20) NULL,
	[KodeDP] [nvarchar](20) NULL,
	[tanggal] [date] NULL,
	[status] [int] NOT NULL,
	[created_by] [nvarchar](20) NULL,
	[created_by_name] [nvarchar](255) NULL,
	[updated_by] [nvarchar](20) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[unbudget_master_dtl]    Script Date: 01/24/2025 15:23:51 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[unbudget_master_dtl](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[master_id] [bigint] NOT NULL,
	[KodeMaterial] [nvarchar](255) NOT NULL,
	[NamaMaterial] [nvarchar](255) NULL,
	[Code_COA] [nvarchar](50) NOT NULL,
	[COA] [nvarchar](255) NULL,
	[QTY] [float] NOT NULL,
	[HargaSatuan] [float] NOT NULL,
	[keterangan] [nvarchar](max) NULL,
	[created_by] [nvarchar](255) NULL,
	[updated_by] [nvarchar](255) NULL,
	[is_deleted] [tinyint] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
ALTER TABLE [dbo].[unbudget_approval] ADD  DEFAULT ('0') FOR [status]
GO
ALTER TABLE [dbo].[unbudget_atn] ADD  DEFAULT ('0') FOR [current_val]
GO
ALTER TABLE [dbo].[unbudget_master] ADD  DEFAULT ('0') FOR [status]
GO
ALTER TABLE [dbo].[unbudget_master_dtl] ADD  DEFAULT ('0') FOR [KodeMaterial]
GO
ALTER TABLE [dbo].[unbudget_master_dtl] ADD  DEFAULT ('') FOR [NamaMaterial]
GO
ALTER TABLE [dbo].[unbudget_master_dtl] ADD  DEFAULT ('0') FOR [QTY]
GO
ALTER TABLE [dbo].[unbudget_master_dtl] ADD  DEFAULT ('0') FOR [HargaSatuan]
GO
ALTER TABLE [dbo].[unbudget_master_dtl] ADD  DEFAULT ('0') FOR [is_deleted]
GO
ALTER TABLE [dbo].[unbudget_approval]  WITH CHECK ADD  CONSTRAINT [unbudget_approval_master_id_foreign] FOREIGN KEY([master_id])
REFERENCES [dbo].[unbudget_master] ([id])
GO
ALTER TABLE [dbo].[unbudget_approval] CHECK CONSTRAINT [unbudget_approval_master_id_foreign]
GO
ALTER TABLE [dbo].[unbudget_master_dtl]  WITH CHECK ADD  CONSTRAINT [unbudget_master_dtl_master_id_foreign] FOREIGN KEY([master_id])
REFERENCES [dbo].[unbudget_master] ([id])
GO
ALTER TABLE [dbo].[unbudget_master_dtl] CHECK CONSTRAINT [unbudget_master_dtl_master_id_foreign]
GO
/****** Object:  StoredProcedure [dbo].[InsertNewBAUnbudget]    Script Date: 01/24/2025 15:23:51 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
--ALTER PROCEDURE [dbo].[InsertNewBAUnbudget]
--    @KODE_ST VARCHAR(20) null,
--    @KODE_DP VARCHAR(20) null,
--    @TANGGAL DATE null,
--	@S VARCHAR(max), @E VARCHAR(max), @F VARCHAR(max), @T VARCHAR(max), @O VARCHAR(max),
--	@TEMPAT varchar(255) null,
--	@CREATED_BY varchar(20) null,
--	@CREATED_AT datetime null,
--	@BULAN varchar(5) null,
--	@TAHUN varchar(10) null
--AS
--BEGIN
--	IF @KODE_ST is null OR @KODE_DP is null OR @CREATED_BY is null OR @TEMPAT is null OR @BULAN is null OR @TAHUN is null
--		BEGIN
--			select null as 'NoDocument', null as 'id_master', -1 as 'status', 'KodeST, KodeDP, NIK, Tempat, Bulan Tahun is mandatory' as 'msg'
--			return
--		END

--	return 0
--	return
--	DECLARE @CURRENT_ATN INT = null
--	DECLARE @NEXT_ATN INT = null
--	DECLARE @ID_MASTER INT = NULL
--	DECLARE @NO_DOCUMENT varchar(255) = ''

--	SET @CURRENT_ATN = (SELECT TOP 1 current_val FROM dbo.unbudget_atn where KodeST=@KODE_ST)

--	if @CURRENT_ATN is null 
--	BEGIN
--		SET @CURRENT_ATN = 0
--		INSERT INTO dbo.unbudget_atn (KodeST, current_val) VALUES (@KODE_ST, 0)
--	END

--	SET @NEXT_ATN = @CURRENT_ATN + 1
--	SET @NO_DOCUMENT = CONCAT(@NEXT_ATN, '/', 'BSS-', @KODE_ST, '/', @BULAN, '/', @TAHUN)
--	--SET @NO_DOC = CONCAT(@CURRENT_ATN, '/', 'BSS-', @KODE_ST, '/', @BULAN, '/', @TAHUN)

--	INSERT INTO unbudget_master (NoDocument, tanggal, KodeST, KodeDP, strategi, ekonomi, finance, technology, operation, tempat, created_at, created_by)
--		VALUES (@NO_DOCUMENT, @TANGGAL, @KODE_ST, @KODE_DP, @S, @E, @F, @T, @O, @TEMPAT, @CREATED_AT, @CREATED_BY)
--	SET @ID_MASTER = @@ROWCOUNT

--	UPDATE dbo.unbudget_atn set current_val=@NEXT_ATN where KodeST=@KODE_ST

--	SELECT @NO_DOCUMENT as 'NoDocument', @ID_MASTER as 'id_master', 0 as 'status', 'success' as 'msg'
--END


CREATE PROCEDURE [dbo].[InsertNewBAUnbudget]
    @KODE_ST VARCHAR(20) NULL,
    @KODE_DP VARCHAR(20) NULL,
    @TANGGAL DATE NULL,
    @S VARCHAR(MAX), 
    @E VARCHAR(MAX), 
    @F VARCHAR(MAX), 
    @T VARCHAR(MAX), 
    @O VARCHAR(MAX),
    @TEMPAT VARCHAR(255) NULL,
    @CREATED_BY VARCHAR(20) NULL,
    @CREATED_AT DATETIME NULL,
    @BULAN VARCHAR(5) NULL,
    @TAHUN VARCHAR(10) NULL
AS
BEGIN
    SET NOCOUNT ON;

    -- Validasi input wajib
    IF @KODE_ST IS NULL OR @KODE_DP IS NULL OR @CREATED_BY IS NULL OR 
       @TEMPAT IS NULL OR @BULAN IS NULL OR @TAHUN IS NULL
    BEGIN
        SELECT 
            NULL AS NoDocument, 
            NULL AS id_master, 
            -1 AS status, 
            'KodeST, KodeDP, NIK, Tempat, Bulan Tahun is mandatory' AS msg;
        RETURN;
    END;

    -- Deklarasi variabel
    DECLARE @CURRENT_ATN INT = NULL;
    DECLARE @NEXT_ATN INT = NULL;
    DECLARE @ID_MASTER INT = NULL;
    DECLARE @NO_DOCUMENT VARCHAR(255) = '';

    -- Ambil nilai current_val dari unbudget_atn
    SET @CURRENT_ATN = (SELECT TOP 1 current_val FROM dbo.unbudget_atn WHERE KodeST = @KODE_ST);

    -- Jika tidak ditemukan, buat entry baru
    IF @CURRENT_ATN IS NULL
    BEGIN
        SET @CURRENT_ATN = 0;
        INSERT INTO dbo.unbudget_atn (KodeST, current_val) VALUES (@KODE_ST, 0);
    END;

    -- Hitung nilai berikutnya
    SET @NEXT_ATN = @CURRENT_ATN + 1;
    SET @NO_DOCUMENT = CONCAT(@NEXT_ATN, '/', 'BSS-', @KODE_ST, '/', @BULAN, '/', @TAHUN);

    -- Insert ke tabel unbudget_master
    INSERT INTO unbudget_master (
        NoDocument, tanggal, KodeST, KodeDP, strategi, ekonomi, finance, 
        technology, operation, tempat, created_at, created_by
    )
    VALUES (
        @NO_DOCUMENT, @TANGGAL, @KODE_ST, @KODE_DP, @S, @E, @F, @T, @O, 
        @TEMPAT, ISNULL(@CREATED_AT, GETDATE()), @CREATED_BY
    );

    -- Ambil ID dari baris yang baru dimasukkan
    SET @ID_MASTER = SCOPE_IDENTITY();

    -- Update nilai current_val di unbudget_atn
    UPDATE dbo.unbudget_atn SET current_val = @NEXT_ATN WHERE KodeST = @KODE_ST;

    -- Kembalikan hasil
    SELECT 
        @NO_DOCUMENT AS NoDocument, 
        @ID_MASTER AS id_master, 
        0 AS status, 
        'success' AS msg;
END;
GO

INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010101', '1000', 'Beban Gaji dan Upah');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010102', '1000', 'Beban Tunjangan PPH21');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010103', '1000', 'Beban Lembur');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010104', '1000', 'Beban Uang Kehadiran');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010105', '1000', 'Beban Tunjangan Makan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010106', '1000', 'Beban Insentif');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010107', '1000', 'Beban THR dan Bonus');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010108', '1000', 'Beban Pesangon');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010109', '1000', 'Beban BPJS Jaminan Hari Tua');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010110', '1000', 'Beban BPJS Kesehatan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010111', '1000', 'Beban BPJS Pensiun');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010112', '1000', 'Beban Tunjangan Transportasi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010113', '1000', 'Beban Cuti Besar');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010114', '1000', 'Beban Upah Harian');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010115', '1000', 'Beban BPJS JKK dan JKM');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010116', '1000', 'Beban Tunjangan Tetap');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010117', '1000', 'Beban Uang Lapangan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010118', '1000', 'Beban Kompensasi Jabatan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010119', '1000', 'Beban Kompensasi Skill');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010120', '1000', 'Beban Imbalan Paska Kerja');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010121', '1000', 'Beban Insentif Natura');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010201', '1000', 'Beban Makan dan Minum');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010202', '1000', 'Beban Makan dan Minum (Non Catering)');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010203', '1000', 'Beban Kebutuhan Site/Mess');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010204', '1000', 'Beban Kematian');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010205', '1000', 'Beban Pernikahan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010206', '1000', 'Beban Transportasi Cuti');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010207', '1000', 'Beban Penggantian Kacamata');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010208', '1000', 'Beban Rumah Sakit');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010209', '1000', 'Beban Pengobatan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010210', '1000', 'Beban Fasilitas Olah Raga');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010211', '1000', 'Beban Family Gathering');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010212', '1000', 'Beban Laundry');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010301', '1000', 'Beban Listrik dan Air');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010302', '1000', 'Beban Telephone');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010303', '1000', 'Beban Handphone');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010304', '1000', 'Beban Internet');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010305', '1000', 'Beban Modem/ Kuota');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010306', '1000', 'Beban TV Kabel');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010401', '1000', 'Beban Alat Tulis Kantor');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010403', '1000', 'Beban Pos dan Meterai');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010404', '1000', 'Beban Fotocopy, Jilid dan Cetakan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010405', '1000', 'Beban Pengurusan Surat Kantor');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010406', '1000', 'Beban Perijinan/ Surat Kendaraan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010407', '1000', 'Beban Keamanan dan Kebersihan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010408', '1000', 'Beban Koran dan Majalah');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010409', '1000', 'Beban P3K');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010410', '1000', 'Beban Iklan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010411', '1000', 'Beban Recruitment');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010412', '1000', 'Beban Rumah Tangga Kantor');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010414', '1000', 'Beban Perijinan dan Sertifikasi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010415', '1000', 'Beban Lab dan Analisa Sampel');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010501', '1000', 'Beban Pemeliharaan Bangunan/Prasarana');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010502', '1000', 'Beban Pemeliharaan Mesin');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010503', '1000', 'Beban Pemeliharaan Alat Berat');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010504', '1000', 'Beban Pemeliharaan Kendaraan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010505', '1000', 'Beban Pemeliharaan Peralatan & Perlengkapan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010506', '1000', 'Beban Peralatan dan Perlengkapan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010507', '1000', 'Beban Tools');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010601', '1000', 'Beban Asuransi Kendaraan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010602', '1000', 'Beban Asuransi Bangunan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010603', '1000', 'Beban Asuransi Karyawan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010604', '1000', 'Beban Asuransi Pengiriman/Mobilisasi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010609', '1000', 'Beban Asuransi Lainnya');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010701', '1000', 'Beban Penyusutan Bangunan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010702', '1000', 'Beban Penyusutan Kendaraan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010703', '1000', 'Beban Penyusutan Mesin');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010704', '1000', 'Beban Penyusutan Infrastruktur');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010705', '1000', 'Beban Penyusutan Peralatan & Perlengkapan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010706', '1000', 'Beban Amortisasi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010708', '1000', 'Beban Penyusutan Alat Berat Leasing');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010709', '1000', 'Beban Penyusutan Kendaraan Leasing');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010710', '1000', 'Beban Penyusutan Mesin Leasing');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010711', '1000', 'Beban Penyusutan Bangunan Leasing');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010712', '1000', 'Beban Penyusutan Peralatan dan Perlengkapan Leas');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010801', '1000', 'Beban Perjalanan Dinas');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010901', '1000', 'Beban Sewa Bangunan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010902', '1000', 'Beban Sewa Kendaraan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61010903', '1000', 'Beban Sewa Peralatan & Perlengkapan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011001', '1000', 'Beban Pendidikan & Pelatihan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011002', '1000', 'Beban Rapat dan Konferensi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011101', '1000', 'Beban Tenaga Ahli');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011102', '1000', 'Beban Notaris');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011103', '1000', 'Beban Komisi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011104', '1000', 'Beban Konsultan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011105', '1000', 'Beban Management Fee');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011201', '1000', 'Beban Survey');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011301', '1000', 'Beban Jamuan dan Hadiah');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011302', '1000', 'Beban Sumbangan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011303', '1000', 'Beban Representatif');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011304', '1000', 'Beban Corporate Social Responsibility');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011305', '1000', 'Beban Promosi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011401', '1000', 'Beban Leasing');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011501', '1000', 'Beban BBM, Parkir dan Tol');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011502', '1000', 'Beban Transport');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011503', '1000', 'Beban Pengiriman/ Expedisi Barang');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011504', '1000', 'Beban Mobilisasi Kendaraan/ Unit');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011505', '1000', 'Beban Import');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011506', '1000', 'Beban Pelabuhan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011601', '1000', 'Beban Seragam');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011602', '1000', 'Beban Perlengkapan SHE/ Safety');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011701', '1000', 'Beban Pajak PPh 21');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011702', '1000', 'Beban Pajak PPh 22');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011703', '1000', 'Beban Pajak PPh 23');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011704', '1000', 'Beban Pajak PPh 25');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011705', '1000', 'Beban Pajak PPh 29');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011706', '1000', 'Beban Pajak PPh Final');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011707', '1000', 'Beban Pajak Daerah dan Retribusi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('61011708', '1000', 'Beban Pajak Lainnya');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010101', '1000', 'Beban Gaji dan Upah');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010102', '1000', 'Beban Tunjangan PPH21');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010103', '1000', 'Beban Lembur');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010104', '1000', 'Beban Uang Kehadiran');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010105', '1000', 'Beban Tunjangan Tetap');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010106', '1000', 'Beban Insentif');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010107', '1000', 'Beban THR dan Bonus');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010108', '1000', 'Beban Pesangon');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010109', '1000', 'Beban BPJS Jaminan Hari Tua');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010110', '1000', 'Beban BPJS Kesehatan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010111', '1000', 'Beban BPJS Pensiun');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010112', '1000', 'Beban Tunjangan Transportasi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010113', '1000', 'Beban Upah Harian');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010114', '1000', 'Beban BPJS JKK dan JKM');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010115', '1000', 'Beban Uang Lapangan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010116', '1000', 'Beban Kompensasi Jabatan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010117', '1000', 'Beban Kompensasi Skill');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010118', '1000', 'Beban Imbalan Paska Kerja');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010119', '1000', 'Beban Insentif Natura');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010201', '1000', 'Beban Makan dan Minum');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010202', '1000', 'Beban Makan dan Minum (Non Catering)');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010203', '1000', 'Beban Laundry Mess');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010204', '1000', 'Beban Kebutuhan Site/Mess');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010205', '1000', 'Beban Kematian');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010206', '1000', 'Beban Pernikahan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010207', '1000', 'Beban Transportasi Cuti');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010208', '1000', 'Beban Rumah Sakit');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010209', '1000', 'Beban Pengobatan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010210', '1000', 'Beban Cuti Besar');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010211', '1000', 'Beban Fasilitas Olah Raga');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010301', '1000', 'Beban Listrik dan Air');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010302', '1000', 'Beban Telephone');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010303', '1000', 'Beban Handphone');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010304', '1000', 'Beban Internet');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010305', '1000', 'Beban Modem/ Kuota');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010306', '1000', 'Beban TV Kabel');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010401', '1000', 'Beban Alat Tulis Kantor');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010402', '1000', 'Beban Fotocopy, Jilid dan Cetakan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010403', '1000', 'Beban Pos dan Meterai');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010404', '1000', 'Beban P3K');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010405', '1000', 'Beban Keamanan dan Kebersihan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010408', '1000', 'Beban Perijinan dan Sertifikasi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010409', '1000', 'Beban Lab dan Analisa Sampel');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010410', '1000', 'Beban Recruitment');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010501', '1000', 'Beban Pemakaian Sparepart');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010502', '1000', 'Beban Pemakaian Ban & Velg');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010503', '1000', 'Beban Pemakaian Oli');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010504', '1000', 'Beban Pemakaian Grease');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010505', '1000', 'Beban Pemakaian Coolant');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010506', '1000', 'Beban Pemakaian Consumable');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010601', '1000', 'Beban BBM Produksi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010602', '1000', 'Beban Angkut BBM Produksi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010701', '1000', 'Beban Blasting');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010801', '1000', 'Beban Pemeliharaan Bangunan/Prasarana');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010802', '1000', 'Beban Pemeliharaan Mesin');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010803', '1000', 'Beban Pemeliharaan Alat Berat');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010804', '1000', 'Beban Pemeliharaan Kendaraan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010805', '1000', 'Beban Pemeliharaan Peralatan & Perlengkapan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010806', '1000', 'Beban Peralatan dan Perlengkapan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010807', '1000', 'Beban Tools');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010901', '1000', 'Beban Asuransi Alat Berat');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010902', '1000', 'Beban Asuransi Kendaraan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010903', '1000', 'Beban Asuransi Bangunan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51010904', '1000', 'Beban Asuransi Karyawan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011001', '1000', 'Beban Penyusutan Bangunan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011002', '1000', 'Beban Penyusutan Alat Berat');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011003', '1000', 'Beban Penyusutan Kendaraan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011004', '1000', 'Beban Penyusutan Mesin');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011005', '1000', 'Beban Penyusutan Infrastruktur');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011006', '1000', 'Beban Penyusutan Peralatan & Perlengkapan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011007', '1000', 'Beban Penyusutan Alat Berat Leasing');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011008', '1000', 'Beban Penyusutan Kendaraan Leasing');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011009', '1000', 'Beban Penyusutan Mesin Leasing');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011010', '1000', 'Beban Penyusutan Bangunan Leasing');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011011', '1000', 'Beban Penyusutan Peralatan dan Perlengkapan Leas');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011101', '1000', 'Beban Perjalanan Dinas');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011201', '1000', 'Beban Survey');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011301', '1000', 'Beban Konsultan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011302', '1000', 'Beban Management Fee');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011303', '1000', 'Beban Tenaga Ahli');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011401', '1000', 'Beban Sewa Bangunan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011402', '1000', 'Beban Sewa Kendaraan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011403', '1000', 'Beban Sewa Alat Berat');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011404', '1000', 'Beban Sewa Peralatan & Perlengkapan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011501', '1000', 'Beban Pendidikan & Pelatihan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011502', '1000', 'Beban Rapat dan Konferensi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011601', '1000', 'Beban Jamuan dan Hadiah');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011602', '1000', 'Beban Sumbangan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011603', '1000', 'Beban Representatif');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011604', '1000', 'Beban Corporate Social Responsibility');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011605', '1000', 'Beban Promosi');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011701', '1000', 'Beban BBM, Parkir dan Tol');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011702', '1000', 'Beban Transport');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011703', '1000', 'Beban Pengiriman/ Expedisi Barang');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011704', '1000', 'Beban Mobilisasi Kendaraan/ Unit');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011705', '1000', 'Beban Pelabuhan');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011801', '1000', 'Beban Seragam');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011802', '1000', 'Beban Perlengkapan SHE/ Safety');
INSERT INTO unbudget_m_coa (Code_COA, CoCd, COA) VALUES ('51011901', '1000', 'Beban Leasing');

