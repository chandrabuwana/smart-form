DROP TABLE  IF EXISTS [CPM_ACTIVITY_LOGS]
DROP TABLE IF EXISTS  [CPM_M_OBJ_CATEGORY]
DROP TABLE  IF EXISTS [CPM_M_OBJ]
DROP TABLE IF EXISTS  [CPM_M_FORM_APPROVAL]
DROP TABLE  IF EXISTS [CPM_M_FORM_JENIS_APPROVAL]
DROP TABLE IF EXISTS  [CPM_APPROVAL]
DROP TABLE  IF EXISTS [CPM_M_FORM_DTL]
DROP TABLE IF EXISTS  [CPM_M_FORM]

USE [DB_DEV_SMARTFORM]
GO
/****** Object:  Table [dbo].[cpm_activity_logs]    Script Date: 02/18/2025 15:34:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cpm_activity_logs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[id_m_cpm] [bigint] NOT NULL,
	[changed_type] [nvarchar](50) NOT NULL,
	[changed_dtl] [text] NULL,
	[created_by] [nvarchar](20) NULL,
	[updated_by] [nvarchar](20) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[revisi_ke] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[cpm_approval]    Script Date: 02/18/2025 15:34:22 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cpm_approval](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[id_m_cpm] [bigint] NOT NULL,
	[id_m_approval] [bigint] NOT NULL,
	[stts] [int] NOT NULL,
	[created_by] [nvarchar](20) NULL,
	[updated_by] [nvarchar](20) NULL,
	[is_deleted] [tinyint] NOT NULL,
	[sebagai] [nvarchar](50) NULL,
	[urutan] [int] NOT NULL,
	[keterangan] [nvarchar](max) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[cpm_m_form]    Script Date: 02/18/2025 15:34:22 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cpm_m_form](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[KodeST] [nvarchar](20) NULL,
	[TanggalSubmit] [date] NULL,
	[created_by] [nvarchar](20) NULL,
	[updated_by] [nvarchar](20) NULL,
	[is_deleted] [tinyint] NOT NULL,
	[stts] [int] NOT NULL,
	[keterangan] [text] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[cpm_m_form_approval]    Script Date: 02/18/2025 15:34:22 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cpm_m_form_approval](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[id_jenis_approval] [bigint] NOT NULL,
	[nik] [nvarchar](255) NOT NULL,
	[KodeST] [nvarchar](20) NULL,
	[KodeDP] [nvarchar](20) NULL,
	[urutan] [int] NOT NULL,
	[sebagai] [nvarchar](50) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[cpm_m_form_dtl]    Script Date: 02/18/2025 15:34:22 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cpm_m_form_dtl](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[id_m_cpm] [bigint] NOT NULL,
	[id_m_obj] [bigint] NOT NULL,
	[UOM] [nvarchar](255) NULL,
	[HIG_HIB] [nvarchar](255) NULL,
	[plan_b_1] [nvarchar](255) NULL,
	[act_b_1] [nvarchar](255) NULL,
	[plan_b_2] [nvarchar](255) NULL,
	[act_b_2] [nvarchar](255) NULL,
	[plan_b_3] [nvarchar](255) NULL,
	[act_b_3] [nvarchar](255) NULL,
	[plan_b_4] [nvarchar](255) NULL,
	[act_b_4] [nvarchar](255) NULL,
	[plan_b_5] [nvarchar](255) NULL,
	[act_b_5] [nvarchar](255) NULL,
	[plan_b_6] [nvarchar](255) NULL,
	[act_b_6] [nvarchar](255) NULL,
	[plan_b_7] [nvarchar](255) NULL,
	[act_b_7] [nvarchar](255) NULL,
	[plan_b_8] [nvarchar](255) NULL,
	[act_b_8] [nvarchar](255) NULL,
	[plan_b_9] [nvarchar](255) NULL,
	[act_b_9] [nvarchar](255) NULL,
	[plan_b_10] [nvarchar](255) NULL,
	[act_b_10] [nvarchar](255) NULL,
	[plan_b_11] [nvarchar](255) NULL,
	[act_b_11] [nvarchar](255) NULL,
	[plan_b_12] [nvarchar](255) NULL,
	[act_b_12] [nvarchar](255) NULL,
	[plan_q1] [nvarchar](255) NULL,
	[act_q1] [nvarchar](255) NULL,
	[plan_q2] [nvarchar](255) NULL,
	[act_q2] [nvarchar](255) NULL,
	[plan_q3] [nvarchar](255) NULL,
	[act_q3] [nvarchar](255) NULL,
	[plan_q4] [nvarchar](255) NULL,
	[act_q4] [nvarchar](255) NULL,
	[plan_yearly] [nvarchar](255) NULL,
	[act_yearly] [nvarchar](255) NULL,
	[created_by] [nvarchar](20) NULL,
	[updated_by] [nvarchar](20) NULL,
	[is_deleted] [tinyint] NOT NULL,
	[stts] [int] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[cpm_m_form_jenis_approval]    Script Date: 02/18/2025 15:34:22 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cpm_m_form_jenis_approval](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nama] [nvarchar](60) NOT NULL,
	[urutan] [int] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[cpm_m_obj]    Script Date: 02/18/2025 15:34:22 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cpm_m_obj](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[id_obj_category] [bigint] NOT NULL,
	[nama] [nvarchar](100) NOT NULL,
	[created_by] [nvarchar](20) NULL,
	[updated_by] [nvarchar](20) NULL,
	[is_deleted] [tinyint] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[cpm_m_obj_category]    Script Date: 02/18/2025 15:34:22 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cpm_m_obj_category](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nama] [nvarchar](60) NOT NULL,
	[created_by] [nvarchar](20) NULL,
	[updated_by] [nvarchar](20) NULL,
	[is_deleted] [tinyint] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

SET IDENTITY_INSERT [dbo].[cpm_m_obj] ON 
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (1, 1, N'OB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (2, 1, N'COAL', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (3, 1, N'SR', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (4, 1, N'COAL (in bcm)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (5, 1, N'COAL Hauling', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (6, 1, N'Ton KM (Hauling)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (7, 1, N'Jarak OB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (8, 1, N'Jarak CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (9, 1, N'Jarak CO HAULING (KM)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (10, 1, N'Ton KM', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (11, 1, N'Jarak CO HAULING', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (12, 3, N'PC2000 (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (13, 3, N'PC2000 (Soft Material)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (14, 3, N'PC2000 (Mud)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (15, 3, N'PC1250 (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (16, 3, N'PC1250 (Mud)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (17, 3, N'XE900D (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (18, 3, N'XE900D (Mud)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (19, 3, N'ZX870/XE700D/850LC-9 (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (20, 3, N'ZX870 (Mud)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (21, 3, N'ZX470/PC400/E6500F', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (22, 3, N'PC2000', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (23, 3, N'SE980LCW', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (24, 3, N'XE930D', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (25, 3, N'XE900D', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (26, 3, N'ZX870 (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (27, 3, N'XE700D (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (28, 3, N'ZX350 (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (29, 3, N'ZX350 (MUD)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (30, 3, N'PC1250(OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (31, 3, N'E6550F (OB) ', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (32, 3, N'X870H', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (33, 3, N'XE1250', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (34, 3, N'PC2000 (Sift Material)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (35, 3, N'XE2000 (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (36, 3, N'XE2000 (MUD)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (37, 3, N'E6550F (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (38, 4, N'PC500 (CO)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (39, 4, N'ZX470 (CO)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (40, 4, N'ZX350 (CO)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (41, 4, N'E6650F (CO)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (42, 4, N'ZX200 (CO)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (43, 4, N'XE900D', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (44, 4, N'ZX870/XE700D/850LC-9 (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (45, 4, N'E6350H', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (46, 4, N'PC1250', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (47, 4, N'ZX350', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (48, 4, N'E6550F', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (49, 5, N'HD785 (PC-2000)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (50, 5, N'HD785 (PC-1250) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (51, 5, N'HD785 (PC-1250) (Mud)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (52, 5, N'HD465 (PC-1250) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (53, 5, N'HD465 (PC-1250) (Mud)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (54, 5, N'CMT106 (PC-1250) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (55, 5, N'CMT106 (PC-1250) (Mud)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (56, 5, N'CMT106 (XE900D) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (57, 5, N'CMT106 (ZX870/XE700D/850LC) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (58, 5, N'CMT106 (ZX870/XE700D/850LC) (Mud)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (59, 5, N'CMT96 (ZX870/XE700D/850LC) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (60, 5, N'CMT96 (ZX470/PC400/E6500F) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (61, 5, N'RTH100 (PC-2000) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (62, 5, N'RTH100 (PC-2000) (MUD)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (63, 5, N'RTH100 (PC-1250) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (64, 5, N'RTH100 (PC-870) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (65, 5, N'DT 38 Ton Hauling', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (66, 5, N'DT 36 Ton Hauling', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (67, 5, N'DT 30 Ton Hauling', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (68, 5, N'DT 26 Ton Hauling', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (69, 5, N'DONGFENG DF3310', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (70, 5, N'ACTROS', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (71, 5, N'EWH', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (72, 5, N'UA', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (73, 5, N'Road Condition Index (RCI) - OB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (74, 5, N'Road Condition Index (RCI) - CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (75, 5, N'Dewatering Index (DWI)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (76, 5, N'Disposal Condition Index (DCI)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (77, 5, N'Front Condition Index (FCI) - OB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (78, 5, N'Front Condition Index (FCI) - CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (79, 5, N'DONGFENG DFH3310A12', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (80, 5, N'CMT106 (ZX870) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (81, 5, N'CMT106 (ZX870) (MUD)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (82, 5, N'CMT106 (XE700) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (83, 5, N'CMT 106 (ZX350) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (84, 5, N'CMT 106 (ZX350) (MUD)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (85, 5, N'CMT106 (ZX470/PC400/E6500F) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (86, 5, N'CMT106  (X6550F) (OB)        ', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (87, 5, N'CMT106 (ZX870H) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (88, 5, N'HD785 (PC-2000) (OB)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (89, 6, N'Join Survey vs Truck count', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (90, 6, N'Mine Design Accuracy', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (91, 6, N'Lead Time Berita Acara (BA)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (92, 6, N'Matching Factor', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (93, 6, N'Fuel Ratio Mining', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (94, 6, N'Fuel Ratio Hauling', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (95, 7, N'(PA) - ALL CLUSTER', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (96, 7, N'(PA) - LOADING OB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (97, 7, N'(PA) - LOADING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (98, 7, N'(PA) - HAULING OB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (99, 7, N'(PA) - MINING - HAULING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (100, 7, N'(PA) - HAULING - HAULING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (101, 7, N'(PA) - RIPDOZ', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (102, 7, N'(PA) - ROAD MAINTENANCE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (103, 7, N'(PA) - DEWATERING', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (104, 7, N'(PA) - DRILL & BLAST', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (105, 7, N'(PA) - OTHER', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (106, 7, N'(PA) - HAULING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (107, 8, N'MTBF - ALL CLUSTER', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (108, 8, N'MTBF - LOADING OB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (109, 8, N'MTBF - LOADING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (110, 8, N'MTBF - HAULING OB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (111, 8, N'MTBF - MINING - HAULING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (112, 8, N'MTBF - HAULING - HAULING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (113, 8, N'MTBF - RIPDOZ', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (114, 8, N'MTBF - ROAD MAINTENANCE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (115, 8, N'MTBF - DEWATERING', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (116, 8, N'MTBF - DRILL & BLAST', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (117, 8, N'MTBF - OTHER', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (118, 8, N'MTBF - HAULING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (119, 9, N'MTTR - ALL CLUSTER', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (120, 9, N'MTTR - LOADING OB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (121, 9, N'MTTR - LOADING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (122, 9, N'MTTR - HAULING OB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (123, 9, N'MTTR - MINING - HAULING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (124, 9, N'MTTR - HAULING - HAULING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (125, 9, N'MTTR - RIPDOZ', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (126, 9, N'MTTR - ROAD MAINTENANCE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (127, 9, N'MTTR - DEWATERING', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (128, 9, N'MTTR - DRILL & BLAST', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (129, 9, N'MTTR - OTHER', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (130, 9, N'MTTR - HAULING CO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (131, 10, N'LIFE TIME TYRE 16.00 R25', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (132, 10, N'LIFE TIME TYRE 12.00 R24', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (133, 10, N'LIFE TIME TYRE 27.00 R49', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (134, 10, N'LIFE TIME TYRE 505/95 R29', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (135, 10, N'LIFE TIME COMPONEN ENGINE CMT96/CMT106', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (136, 10, N'REDO SERVICE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (137, 10, N'BREAKDOWN SCHEDULE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (138, 10, N'LIFE TIME TYRE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (139, 10, N'LIFE TIME COMPONEN ENGINE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (140, 10, N'BREAKDOWN SCHEDULE UNSCHEDULE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (141, 10, N'BREAKDOWN UNSCHEDULE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (142, 11, N'SHE Index', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (143, 11, N'SAFETY PERFORMANCE (TIFR)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (144, 11, N'HEALTH PERFORMANCE (PAK FR)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (145, 11, N'ENVIRO PERFORMANCE (EI)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (146, 11, N'IBPR COMPLY', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (147, 11, N'FATALITY', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (148, 11, N'LTIFR (Lost Time Injury Frequency Rate)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (149, 11, N'OHD (Occupational Health Diseases)/ PAK (Penyakit Akibat Kerja)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (150, 11, N'SAP Achievement (Safety Accountability Program)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (151, 11, N'FMP Achievement (Fatigue Management Program)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (152, 11, N'OHIH Achievement (Occupational Health & Hygiene Industry)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (153, 11, N'TSM Achievement (Traffic Safety Management)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (154, 11, N'ERP Level (Emergency Response & Preparedness Level 2)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (155, 11, N'EPP Achievement (Enviro Protection Program)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (156, 11, N'FPMP Achievement  (Fire Protection Management Program)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (157, 11, N'CAPA  Achievement (Closing ALL CAPA)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (158, 11, N'MIFR (Minor Injury Frequency Rate)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (159, 11, N'FIFR (Fire Incident Frequency Rate)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (160, 11, N'PDFRate (Property Damage Frequency Rate)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (161, 11, N'EIFR (Enviro Incident Frequency Rate)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (162, 11, N'QSAP', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (163, 11, N'FIRE INCIDENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (164, 12, N'SERVICE RATIO (SR)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (165, 12, N'READINESS PARTS', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (166, 12, N'INVENTORY TURN OVER (ITO)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (167, 13, N'PRODUKTIVITAS MP', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (168, 13, N'ATTENDANCET RATIO (ATR)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (169, 13, N'EMPLOYEE TURN OVER RATIO (TOR)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (170, 13, N'RATIO MEKANIK : PENGAWAS', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (171, 13, N'EMPLOYEE SATISFACTION INDEX', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (172, 13, N'RATIO OPERATOR : PENGAWAS', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (173, 14, N'LEADTIME PROJECT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (174, 14, N'Achievement Maintanance Project', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (175, 14, N'AKURASI RAB', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (176, 15, N'Vendor Performance (%)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (177, 15, N'Arrival On Time Bus Sarana', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (178, 15, N'Phisical Availability Bus', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (179, 15, N'Phisical Availability Light Vehicle (LV)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (180, 15, N'Accuration Catering Order', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (181, 15, N'Facility Performance (%)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (182, 15, N'Catering Delivery On Time', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (183, 15, N'AKG', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (184, 15, N'Asset GS Performance (%)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (185, 15, N'CSR Program', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (186, 15, N'Kondusifitas Keamanan Project ', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (187, 16, N'DATA DRIVEN', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (188, 16, N'CASH FLOW PROJECTION', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (189, 16, N'DATA GOVERNANCE ACHIEVEMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (190, 16, N'BUDGET ACCURACY', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (191, 16, N'COST ACCURACY', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (192, 16, N'DATA QUALITY ACHIEVEMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (193, 16, N'CENTRALIZED DATA ACHIEVEMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (194, 16, N'INTEGRATED DATA ACHIEVEMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (195, 16, N'ON TIME BUDGETING', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (196, 16, N'PARAMETER ACCURACY', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (197, 16, N'SPEND VARIANCE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (198, 16, N'TIMELY REPORTING', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (199, 16, N'DATA VALIDATION', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (200, 16, N'REALTIME DATA INPUT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (201, 16, N'GOOD ACCESSIBILITY', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (202, 16, N'DATA SECURITY ACHIEVEMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (203, 17, N'INTERNAL AUDIT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (204, 17, N'INTERNAL AUDIT INDEX ', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (205, 17, N'QUALITY ASSURANCE INTERNAL AUDIT ', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (206, 17, N'COVERAGE SYSTEM', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (207, 17, N'AUDIT SCORE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (208, 17, N'CLOSING TEMUAN AUDIT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (209, 17, N'INTERNAL AUDIT MANAGEMENT SYSTEM ', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (210, 17, N'AKURASI SCHEDULE AUDIT ', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (211, 17, N'LEAD TIME AUDIT REPORT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (212, 17, N'CONSULTATION & ASSISTANCE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (213, 17, N'CUSTOMER SATISFACTION INTERNAL AUDIT (INDEX)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (214, 17, N'AUDITEE SATISFACTION INTERNAL AUDIT (INDEX)', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (215, 17, N'CASHFLOW RATIO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (216, 17, N'ROA', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (217, 17, N'ROE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (218, 18, N'LEGAL COMPLIANCE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (219, 18, N'LEGAL CORPORATE ACHIEVEMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (220, 18, N'DRAFTING/REVIEW PERJANJIAN', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (221, 18, N'TIME ACCURACY CONTRACT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (222, 18, N'LEGAL KOMERSIL', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (223, 18, N'LITIGATION & NON LITIGATION SATISFACTION INDEX', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (224, 18, N'CASE MANAGEMENT REPORTS', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (225, 18, N'PROGRESS CASE REPORTS', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (226, 18, N'ANALISIS RESIKO', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (227, 18, N'PERMIT ACCURACY', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (228, 18, N'TIME PERMIT ACCURACY', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (229, 18, N'PARAMETER PERMIT ACCURACY', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (230, 19, N'BUSINESS DEVELOPMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (231, 19, N'BUSINESS INTELLIGENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (232, 19, N'COMPETITOR ANALYST', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (233, 19, N'VOLUME COMPETITOR', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (234, 19, N'PROJECT AREA COMPETITOR', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (235, 19, N'MARKET ANALYST', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (236, 19, N'PROJECT MAP', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (237, 19, N'NEW PROJECT DEVELOPMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (238, 19, N'PROSPECTING NEW PROJECT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (239, 19, N'ANALISA NEW PROJECT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (240, 19, N'FORECASTING NEW PROJECT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (241, 19, N'TENDER REQUIEREMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (242, 19, N'FEASIBILITY STUDY', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (243, 19, N'OFFERING RATE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (244, 19, N'PROJECT MANAGEMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (245, 19, N'REGULER PROJECT REVIEW', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (246, 19, N'MAINTAIN ISSUE PROJECT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (247, 19, N'ACH. PRODUKSI OB & COAL', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (248, 19, N'CONTRACT MANAGEMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (249, 19, N'COMMERCIAL PROJECT REVIEW', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (250, 19, N'CASH COST SENSITIVITY PROJECT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (251, 19, N'ACCOUNT RECEIVABLE', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (252, 19, N'ON TIME PAYMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (253, 19, N'PROJECT SETTLEMENT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (254, 19, N'ACH. 4M + 1E', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (255, 19, N'CONTRACT PREPARATION', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (256, 19, N'SUSTAINIBILITY PROJECT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (257, 19, N'JOINT SIGN OPERATION', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (258, 19, N'LIFE OF MINE PROJECT', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (259, 19, N'COMPANY BRANDING', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (260, 19, N'ACH. CONTENT DIGITAL', NULL, NULL, 0, NULL, NULL)
GO
INSERT [dbo].[cpm_m_obj] ([id], [id_obj_category], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (261, 19, N'ACH. EVENT & SPONSORSHIP', NULL, NULL, 0, NULL, NULL)
GO
SET IDENTITY_INSERT [dbo].[cpm_m_obj] OFF
GO
SET IDENTITY_INSERT [dbo].[cpm_m_obj_category] ON 
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (1, N'-', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (2, N'OPERATIONAL EXCELLENT', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (3, N'Productivity Loader', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (4, N'Productivity Coal', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (5, N'Productivity Hauler', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (6, N'ENGINEERING CAPABILITY', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (7, N'PHYSICAL AVAILABILITY (PA)', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (8, N'MEAN TIME BETWEEN FAILURE (MTBF)', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (9, N'MEAN TIME TO REPAIR (MTTR)', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (10, N'LIFE TIME', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (11, N'SHE INDEX', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (12, N'LOGISTIK & SM', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (13, N'ICGS', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (14, N'CVL', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (15, N'GENERAL SERVICE', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (16, N'DATA CENTER', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (17, N'INTERNAL AUDIT', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (18, N'LEGAL', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
INSERT [dbo].[cpm_m_obj_category] ([id], [nama], [created_by], [updated_by], [is_deleted], [created_at], [updated_at]) VALUES (19, N'BUSDEV', N'system', NULL, 0, CAST(N'2025-02-10T14:41:15.480' AS DateTime), NULL)
GO
SET IDENTITY_INSERT [dbo].[cpm_m_obj_category] OFF
GO
ALTER TABLE [dbo].[cpm_activity_logs] ADD  CONSTRAINT [DF_cpm_activity_logs_revisi_ke]  DEFAULT ((0)) FOR [revisi_ke]
GO
ALTER TABLE [dbo].[cpm_approval] ADD  DEFAULT ('0') FOR [stts]
GO
ALTER TABLE [dbo].[cpm_approval] ADD  DEFAULT ('0') FOR [is_deleted]
GO
ALTER TABLE [dbo].[cpm_m_form] ADD  DEFAULT ('0') FOR [is_deleted]
GO
ALTER TABLE [dbo].[cpm_m_form] ADD  DEFAULT ('0') FOR [stts]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_1]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_1]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_2]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_2]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_3]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_3]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_4]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_4]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_5]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_5]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_6]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_6]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_7]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_7]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_8]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_8]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_9]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_9]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_10]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_10]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_11]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_11]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_b_12]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_b_12]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_q1]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_q1]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_q2]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_q2]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_q3]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_q3]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_q4]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_q4]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [plan_yearly]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [act_yearly]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [is_deleted]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] ADD  DEFAULT ('0') FOR [stts]
GO
ALTER TABLE [dbo].[cpm_m_obj] ADD  DEFAULT ('0') FOR [is_deleted]
GO
ALTER TABLE [dbo].[cpm_m_obj_category] ADD  DEFAULT ('0') FOR [is_deleted]
GO
ALTER TABLE [dbo].[cpm_activity_logs]  WITH CHECK ADD  CONSTRAINT [cpm_activity_logs_id_m_cpm_foreign] FOREIGN KEY([id_m_cpm])
REFERENCES [dbo].[cpm_m_form] ([id])
GO
ALTER TABLE [dbo].[cpm_activity_logs] CHECK CONSTRAINT [cpm_activity_logs_id_m_cpm_foreign]
GO
ALTER TABLE [dbo].[cpm_approval]  WITH CHECK ADD  CONSTRAINT [cpm_approval_id_m_approval_foreign] FOREIGN KEY([id_m_approval])
REFERENCES [dbo].[cpm_m_form_approval] ([id])
GO
ALTER TABLE [dbo].[cpm_approval] CHECK CONSTRAINT [cpm_approval_id_m_approval_foreign]
GO
ALTER TABLE [dbo].[cpm_approval]  WITH CHECK ADD  CONSTRAINT [cpm_approval_id_m_cpm_foreign] FOREIGN KEY([id_m_cpm])
REFERENCES [dbo].[cpm_m_form] ([id])
GO
ALTER TABLE [dbo].[cpm_approval] CHECK CONSTRAINT [cpm_approval_id_m_cpm_foreign]
GO
ALTER TABLE [dbo].[cpm_m_form_approval]  WITH CHECK ADD  CONSTRAINT [cpm_m_form_approval_id_jenis_approval_foreign] FOREIGN KEY([id_jenis_approval])
REFERENCES [dbo].[cpm_m_form_jenis_approval] ([id])
GO
ALTER TABLE [dbo].[cpm_m_form_approval] CHECK CONSTRAINT [cpm_m_form_approval_id_jenis_approval_foreign]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl]  WITH CHECK ADD  CONSTRAINT [cpm_m_form_dtl_id_m_cpm_foreign] FOREIGN KEY([id_m_cpm])
REFERENCES [dbo].[cpm_m_form] ([id])
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] CHECK CONSTRAINT [cpm_m_form_dtl_id_m_cpm_foreign]
GO
ALTER TABLE [dbo].[cpm_m_form_dtl]  WITH CHECK ADD  CONSTRAINT [cpm_m_form_dtl_id_m_obj_foreign] FOREIGN KEY([id_m_obj])
REFERENCES [dbo].[cpm_m_obj] ([id])
GO
ALTER TABLE [dbo].[cpm_m_form_dtl] CHECK CONSTRAINT [cpm_m_form_dtl_id_m_obj_foreign]
GO
ALTER TABLE [dbo].[cpm_m_obj]  WITH CHECK ADD  CONSTRAINT [cpm_m_obj_id_obj_category_foreign] FOREIGN KEY([id_obj_category])
REFERENCES [dbo].[cpm_m_obj_category] ([id])
GO
ALTER TABLE [dbo].[cpm_m_obj] CHECK CONSTRAINT [cpm_m_obj_id_obj_category_foreign]
GO


INSERT INTO [dbo].[cpm_m_form_jenis_approval] ([nama], [urutan]) VALUES ('Dibuat oleh', 0)
INSERT INTO [dbo].[cpm_m_form_jenis_approval] ([nama], [urutan]) VALUES ('Disetujui oleh', 1)
INSERT INTO [dbo].[cpm_m_form_jenis_approval] ([nama], [urutan]) VALUES ('Diketahui oleh', 2)